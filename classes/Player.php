<?php

class Player
{
    private $_currentRoom = null;

    private static $_instance = null;

    private function __construct() {}

    /**
     * @static
     * @return Player
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Player();
        }
        return self::$_instance;
    }


    public function setCurrentRoom(MapRoom $room)
    {
        $this->_currentRoom = $room;
    }

    /**
     * @return MapRoom
     */
    public function getCurrentRoom()
    {
        return $this->_currentRoom;
    }


    /**
     * @param $direction
     * @return string
     */
    public function go($direction)
    {
        $directionSide = $this->_currentRoom->getSide($direction);
        return $directionSide->enter();
    }
}
