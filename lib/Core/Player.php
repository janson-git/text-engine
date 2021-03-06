<?php

namespace Core;

class Player
{
    /** @var MapRoom */
    private $_currentRoom = null;
    /** @var Item[] */
    private $_items = [];

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
        if ($directionSide instanceof MapDoor) {
            return $directionSide->enter();
        }
        return 'Splash! You can\'t go to this direction!';
    }


    /**
     * @param $itemId string
     * @return string
     */
    public function takeItem($itemId)
    {
        // check $itemId - may be it just a part of item name
        // example: given 'test', but we have test_sword and test_box in room.
        $roomItems = $this->_currentRoom->getRoomItemsNamesList();
        
        if (!in_array($itemId, $roomItems) && count($roomItems) > 1) {
            return "What are you want to take: " . implode(', ', $roomItems);
        }
        
        if (count($roomItems) === 1) {
            $itemId = array_pop($roomItems);
        }
        
        $item = $this->_currentRoom->getItem($itemId);
        if (!is_null($item)) {
            $this->_items[$itemId] = $item;
            return "You take " . $itemId . ".";
        }
        return "This room no have " . $itemId . " item.";
    }

    /**
     * @param $itemId string
     * @return string
     */
    public function dropItem($itemId)
    {
        if (isset($this->_items[$itemId])) {
            $item = $this->_items[$itemId];
            unset($this->_items[$itemId]);
            $this->_currentRoom->putItem($item);
            return "You drop " . $itemId . ".";
        }
        return "You do not have " . $itemId . " item.";
    }

    /**
     * @return array
     */
    public function getInventoryList()
    {
        $itemNames = [];
        if (count($this->_items) > 0) {
            foreach ($this->_items as $item) {
                $itemNames[] = $item->getId();
            }
        }
        return $itemNames;
    }
}
