<?php

namespace Core;

use Core\Dictionary\Commands;

class Game
{
    private static $_mazeConfigFilePath = null;
    private static $_mazeConfig = null;
    private static $_gameMaze = null;

    // проверяются направления, для построения лабиринта
    private static $_directions = array('north', 'south', 'west', 'east');

    /**
     * @var MapMazeFactory
     */
    private static $_mapMazeFactory = null;

    private static $_promptLine = '> ';



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
                 
                    // fill game dictionary
                    Dictionary::addItemName($item['id']);
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


    private static $_aliases = array(
        'n' => 'north',
        's' => 'south',
        'w' => 'west',
        'e' => 'east',
        'i' => 'inventory',
        'l' => 'look',
    );


    public static function tryInitCommandCompletion()
    {
        // if readline lib accessible - use it for command completions
        if (function_exists('readline_completion_function')) {
            readline_completion_function(function($currWord, $stringPosition, $cursorInLine) {
                $fullLine = readline_info()['line_buffer'];
                // если это не первое слово - возвращаем список предметов.
                if (strrpos($fullLine, ' ') !== false && strrpos($fullLine, ' ') < strrpos($fullLine, $currWord)) {
                    $roomItems = Player::getInstance()->getCurrentRoom()->getRoomItemsNamesList();
                    $playerItems = Player::getInstance()->getInventoryList();
                    $itemNames = array();
                    foreach ($playerItems as $itemId => $item) {
                        $itemNames[] = $itemId;
                    }
                    $items = array_unique(array_merge($roomItems, $playerItems));
                    return $items;
                }
                // возвращаем список комманд
                return Dictionary::getCommandsList();
            });
        }
    }
    
    /**
     * @return string
     */
    public static function getCommand()
    {
        if (function_exists('readline')) {
            $command = readline(self::$_promptLine);
        } else {
            fputs(STDOUT, self::$_promptLine);
            $command = fgets(STDIN);
        }
        return $command;
    }
    
    /**
     * @static
     * @param string $command
     * @return bool
     */
    public static function executeCommand($command)
    {
        $param = '';
        if (strpos($command, ' ') !== false) {
            list ($command, $param) = explode(' ', $command, 2);
        }

        // check for aliases
        if (strlen($command) < 3) {
            $command = self::getFullCommandFromAlias($command);
        }

        // NEED TO CHECK EXISTS COMMAND (verb) (or check full game dictionary for words?)
        if (!self::isCommandExists($command)) {
            fputs(STDOUT, "Hey! I don't know what are you talking about!\n");
            return false;
        }

        // AND NOW CHECK FOR COMMAND AND RUN IT (check just command and run?)
        if (self::isCommandExists($command)) {
            $message = Command::$command($param);
        } else {
            $message = "Hmmm... I don't now what I shall do.";
        }
        fputs(STDOUT, $message . "\n");
        return true;
    }


    /**
     * Check command exists in game dictionary
     * @param $command
     * @return bool
     */
    private static function isCommandExists($command)
    {
        return in_array($command, Dictionary::getCommandsList());
    }

    /**
     * Check aliases list for full command
     * @param $command
     * @return mixed
     */
    private static function getFullCommandFromAlias($command) {
        $aliases = array_keys(self::$_aliases);
        if (in_array($command, $aliases)) {
            return self::$_aliases[$command];
        }
        return $command;
    }

}
