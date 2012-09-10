<?php

class MapDoor extends MapSite
{
    public function __construct(MapRoom $room1, MapRoom $room2)
    {
        $this->_room1 = $room1;
        $this->_room2 = $room2;
    }

    /**
     * @return string
     */
    public function enter()
    {
        $currentRoom = Player::getInstance()->getCurrentRoom();
        $destRoom = $this->otherSideFrom($currentRoom);
        Player::getInstance()->setCurrentRoom($destRoom);
        $destRoom->enter();
        return $destRoom->getRoomDescription();
    }

    /**
     * @param MapRoom $room
     * @return MapRoom
     */
    public function otherSideFrom(MapRoom $room)
    {
        if ($room == $this->_room1) {
            return $this->_room2;
        } elseif ($room == $this->_room2) {
            return $this->_room1;
        }
    }

    private $_room1;
    private $_room2;
    private $_isOpen;
}
