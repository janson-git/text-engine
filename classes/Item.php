<?php

class Item
{
    private $_itemId;
    private $_description;

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

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }
}
