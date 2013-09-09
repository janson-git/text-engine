<?php

namespace Core;

class MapMazeFactory
{
    public function __construct() {}

    /**
     * @return MapMaze
     */
    public function makeMaze()
    {
        return new MapMaze();
    }

    /**
     * @return MapWall
     */
    public function makeWall()
    {
        return new MapWall();
    }

    /**
     * @param $roomId
     * @return MapRoom
     */
    public function makeRoom($roomId)
    {
        return new MapRoom($roomId);
    }

    /**
     * @param MapRoom $room1
     * @param MapRoom $room2
     * @return MapDoor
     */
    public function makeDoor(MapRoom $room1, MapRoom $room2)
    {
        return new MapDoor($room1, $room2);
    }

}
