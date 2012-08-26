<?php

class Item
{
    private $_itemId;

    public function __construct($itemId)
    {
        $this->_itemId = $itemId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_itemId;
    }
}
