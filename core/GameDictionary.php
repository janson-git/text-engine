<?php


class GameDictionary
{
    protected static $aliases = ['go', 'get'];
    
    public static function getCommandsList()
    {
        $methods = get_class_methods('Command');
        
        return array_unique(array_merge(self::$aliases, $methods));
    }
}