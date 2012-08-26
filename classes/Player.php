<?php

class Player
{
    private $_currentRoom = null;
    private $_items = array();

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


    /**
     * @param $itemId string
     * @return bool
     */
    public function takeItem($itemId)
    {
        $item = $this->_currentRoom->getItem($itemId);
        if (!is_null($item)) {
            $this->_items[$itemId] = $item;
            return true;
        }
        return false;
    }

    /**
     * @param $itemId string
     * @return bool
     */
    public function dropItem($itemId)
    {
        if (isset($this->_items[$itemId])) {
            $item = $this->_items[$itemId];
            unset($this->_items[$itemId]);
            $this->_currentRoom->putItem($item);
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getInventoryList()
    {
        $items = array();
        foreach ($this->_items as $itemId => $item) {
            $items[] = $itemId;
        }

        $itemList = implode(',', $items);
        if (empty($itemList)) {
            $message = "You don't have any items.";
        } else {
            $message = "You have: " . $itemList;
        }
        return $message;
    }
}
