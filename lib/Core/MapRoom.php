<?php

namespace Core;


class MapRoom extends MapSite
{
    private $_sides = array();
    private $_roomId;
    private $_description;
    /** @var Item[] array  */
    private $_items = array();


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
        return null;
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

        $items = array();
        foreach ($this->_items as $itemId => $item) {
            $items[] = $itemId;
        }

        $description = $this->_description;
        $description .= "\n";
        $description .= "Items: " . implode(',', $items);
        $description .= "\n";
        $description .= 'Doors: ' . implode(',', $doors);
        return $description;
    }


    public function putItem(Item $item)
    {
        $this->_items[$item->getId()] = $item;
    }

    /**
     * @param $itemId
     * @return Item|null
     */
    public function getItem($itemId)
    {
        if (isset($this->_items[$itemId])) {
            $item = $this->_items[$itemId];
            unset($this->_items[$itemId]);
            return $item;
        }
        return null;
    }


    /**
     * @param string $partOfname
     * @return Item[]
     */
    public function getRoomItemsList($partOfname = '')
    {
        if (!empty($partOfname)) {
            $temps = [];
            foreach ($this->_items as $item) {
                if (strpos($item->getId(), $partOfname) !== false) {
                    array_push($temps, $item);
                }
            }
            return $temps;
        }
        return $this->_items;
    }

    /**
     * @param string $partOfName
     * @return array
     */
    public function getRoomItemsNamesList($partOfName = '')
    {
        $itemNames = [];
        $roomItems = $this->getRoomItemsList($partOfName);
        if (count($roomItems) > 0) {
            foreach ($roomItems as $item) {
                $itemNames[] = $item->getId();
            }
        }
        return $itemNames;
    }


    public function enter() {}

}