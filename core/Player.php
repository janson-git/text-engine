<?php

class Player
{
    /** @var MapRoom */
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
        return $this->_items;
    }
}
