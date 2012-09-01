<?php

class Game
{
    private static $_gameDictionary = array(
        'north','east','west','south',
        'help','look','take','drop',
        'inventory',
    );
    private static $_aliases = array(
        'n' => 'north',
        's' => 'south',
        'w' => 'west',
        'e' => 'east',
        'i' => 'inventory',
    );

    private static $_mazeConfigFilePath = null;
    private static $_mazeConfig = null;
    private static $_gameMaze = null;

    private static $_directions = array('north', 'south', 'west', 'east');

    /**
     * @var MapMazeFactory
     */
    private static $_mapMazeFactory = null;


    /**
     * @static
     * @param string $filePath
     */
    public static function setMazeConfigFilePath($filePath)
    {
        self::$_mazeConfigFilePath = $filePath;
    }

    private static function loadMazeConfig()
    {
        self::$_mazeConfig = require_once(self::$_mazeConfigFilePath);
    }

    /**
     * @static
     * @param MapMazeFactory $factory
     */
    public static function createMaze(MapMazeFactory $factory)
    {
        self::$_mapMazeFactory = $factory;
        self::loadMazeConfig();

        $gameMaze     = $factory->makeMaze();
        $startRoomObj = null;

        foreach (self::$_mazeConfig['rooms'] as $room) {
            $wallDirections = self::$_directions;
            // check for current room obj
            $roomObj = $gameMaze->getRoom($room['id']);
            if (is_null($roomObj)) {
                $roomObj = $factory->makeRoom($room['id']);
            }
            $roomObj->setRoomDescription($room['description']);

            // check for items in this room
            if (isset($room['items'])) {
                foreach ($room['items'] as $item) {
                    $itemObj = new Item($item['id']);
                    $itemObj->setDescription($item['description']);
                    $roomObj->putItem($itemObj);
                }
            }

            $gameMaze->addRoom($room['id'], $roomObj);

            // check for start room
            if (isset($room['startRoom'])) {
                $startRoomObj = $roomObj;
            }

            // create doors
            foreach ($room['doors'] as $direction => $otherRoomId) {
                // check maze for room, if not exists - create it
                $otherRoomObj = $gameMaze->getRoom($otherRoomId);
                if (is_null($otherRoomObj)) {
                    $otherRoomObj = $factory->makeRoom($otherRoomId);
                    $gameMaze->addRoom($otherRoomId, $otherRoomObj);
                }

                $doorObj = $factory->makeDoor($roomObj, $otherRoomObj);

                $roomObj->setSide($direction, $doorObj);
                $directionKey = array_search($direction, $wallDirections);
                unset($wallDirections[$directionKey]);
            }

            // and now create walls
            foreach ($wallDirections as $direction) {
                $wall = $factory->makeWall();
                $roomObj->setSide($direction, $wall);
            }
        }

        $player = Player::getInstance();
        // set start position in maze
        $player->setCurrentRoom($startRoomObj);

        self::$_gameMaze = $gameMaze;
    }


    /**
     * @static
     * @return MapMazeFactory
     */
    public static function getMapMazeFactory()
    {
        return self::$_mapMazeFactory;
    }


    /**
     * @static
     * @param string $command
     * @return bool
     */
    public static function executeCommand($command)
    {
        if (strpos($command, ' ') !== false) {
            list ($command, $param) = explode(' ', $command, 2);
        }

        // check for aliases
        if (strlen($command) < 3) {
            $command = self::getFullCommandFromAlias($command);
        }

        if (!in_array($command, self::$_gameDictionary)) {
            fputs(STDOUT, "Hey! I don't know what are you talking about!\n");
            return false;
        }

        $player = Player::getInstance();

        switch ($command) {
            case 'help':
                $message = 'Sorry, I can\'t do it...';
                break;

            case 'north':
            case 'south':
            case 'east':
            case 'west':
                $message = Player::getInstance()->go($command);
                break;

            case 'look':
                // now get room description. Now - just get door positions.
                $message = $player->getCurrentRoom()->getRoomDescription();
                break;

            case 'inventory':
                $message = $player->getInventoryList();
                break;

            case 'take':
                $message = $player->takeItem($param);
                break;

            case 'drop':
                $message = $player->dropItem($param);
                break;

            default:
                $message = 'Wow! I know it word, but I don\'t know what to do with it!';
                break;
        }

        fputs(STDOUT, $message . "\n");
    }


    private static function getFullCommandFromAlias($command) {
        $aliases = array_keys(self::$_aliases);
        if (in_array($command, $aliases)) {
            return self::$_aliases[$command];
        }
        return $command;
    }

}
