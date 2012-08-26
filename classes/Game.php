<?php

class Game
{
    private static $_gameDictionary = array(
        'north','east','west','south',
        'help','look'
    );
    private static $_aliases = array(
        'n' => 'north',
        's' => 'south',
        'w' => 'west',
        'e' => 'east',
    );

    private static $_gameMaze = null;


    public static function createMaze(MapMazeFactory $factory)
    {
        // простой лабиринт: комната на севере, комната на юге.
        // между ними дверь. Всё остальное - стены.

        $gameMaze = $factory->makeMaze();

        $northRoom = $factory->makeRoom('north');
        $southRoom = $factory->makeRoom('south');
        $door = $factory->makeDoor($northRoom, $southRoom);

        $northRoom->setRoomDescription("It's a north room of tower. Old prison for political prisoners.");
        $southRoom->setRoomDescription("Nice room with orange walls. Warm wind blows from ventilation on top.");

        $gameMaze->addRoom($northRoom);
        $gameMaze->addRoom($southRoom);

        $northRoom->setSide('north', $factory->makeWall());
        $northRoom->setSide('east', $factory->makeWall());
        $northRoom->setSide('south', $door);
        $northRoom->setSide('west', $factory->makeWall());

        $southRoom->setSide('north', $door);
        $southRoom->setSide('east', $factory->makeWall());
        $southRoom->setSide('south', $factory->makeWall());
        $southRoom->setSide('west', $factory->makeWall());

        $player = Player::getInstance();

        // set start player position
        $player->setCurrentRoom($northRoom);

        self::$_gameMaze = $gameMaze;
    }


    public static function executeCommand($command)
    {
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
