<?php

class MapMaze
{
    private $_rooms = array();

    public function __construct() {}

    public function addRoom($roomId, $room = null)
    {
        $this->_rooms[$roomId] = $room;
    }

    /**
     * @param $roomId
     * @return MapRoom|null
     */
    public function getRoom($roomId)
    {
        if (isset($this->_rooms[$roomId])) {
            return $this->_rooms[$roomId];
        }
        return null;
    }
}
