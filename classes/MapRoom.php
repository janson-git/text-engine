<?php

class MapRoom extends MapSite
{
    public function __construct($roomId)
    {
        $this->_roomId = $roomId;
    }

    public function getRoomId()
    {
        return $this->_roomId;
    }

    /**
     * @param string $direction
     * @return MapSite
     */
    public function getSide($direction) {
        if (isset($this->_sides[$direction])) {
            return $this->_sides[$direction];
        }
    }

    public function setSide($direction, MapSite $type)
    {
        $this->_sides[$direction] = $type;
    }

    public function setRoomDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @return string
     */
    public function getRoomDescription()
    {
        // get room sides description
        $doors = array();
        foreach ($this->_sides as $direction => $side) {
            if ($side instanceof MapDoor) {
                $doors[] = $direction;
            }
        }

        $description = $this->_description;
        $description .= "\n";
        $description .= 'Doors: ' . implode(',', $doors);
        return $description;
    }

    public function enter() {}

    private $_sides = array();
    private $_roomId;
    private $_description;

}
