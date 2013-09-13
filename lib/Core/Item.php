<?php

namespace Core;

class Item
{
    private $_itemId;
    private $_description;
    private $_type;

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

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }
}
