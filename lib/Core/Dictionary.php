<?php

namespace Core;

class DictionaryException extends \Exception {}

class Dictionary
{
    protected static $aliases = ['go', 'get'];
    protected static $items   = [];

    /**
     * @return array
     */
    public static function getCommandsList()
    {
        $methods = get_class_methods('Core\Command');
        return array_unique(array_merge(self::$aliases, $methods));
    }

    /**
     * @return array
     */
    public static function getItemsList()
    {
        return array_unique(self::$items);
    }

    /**
     * @param string $itemId
     * @throws DictionaryException
     */
    public static function addItemName($itemId)
    {
        if (!is_string($itemId)) {
            throw new DictionaryException('Cannot add item ID to items list. Item ID must be string value.');
        }
        array_push(self::$items, $itemId);
    }
}