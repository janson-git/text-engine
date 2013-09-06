<?php

class Command
{

    public static function look($param)
    {
        return Player::getInstance()->getCurrentRoom()->getRoomDescription();
    }

    public static function north()
    {
        return Player::getInstance()->go('north');
    }

    public static function south()
    {
        return Player::getInstance()->go('south');
    }

    public static function east()
    {
        return Player::getInstance()->go('east');
    }

    public static function west()
    {
        return Player::getInstance()->go('west');
    }
    
    public static function go($param)
    {
        return Player::getInstance()->go($param);
    }
    

    public static function help()
    {
        return 'Sorry, I can\'t do it just now...';
    }


    public static function inventory()
    {
        $items = Player::getInstance()->getInventoryList();

        $itemNames = array();
        foreach ($items as $itemId => $item) {
            $itemNames[] = $itemId;
        }

        $itemList = implode(',', $itemNames);
        if (empty($itemList)) {
            $message = "You don't have any items.";
        } else {
            $message = "You have: " . $itemList;
        }
        return $message;
    }

    public static function take($param)
    {
        if (empty($param)) {
            return 'Take what?';
        }
        $player = Player::getInstance();
        if ($param == 'all') {
            $items = $player->getCurrentRoom()->getRoomItemsList();
            if (empty($items)) {
                return 'Nothing to take';
            }
            $messages = array();
            foreach ($items as $itemId => $item) {
                array_push($messages, $player->takeItem($itemId));
            }
            return implode("\n", $messages);
        }
        return $player->takeItem($param);
    }

    /**
     * Alias to 'take' command
     * @param $param
     * @return string
     */
    public static function get($param)
    {
        return self::take($param);
    }


    public static function drop($param)
    {
        if (empty($param)) {
            return 'Drop what?';
        }
        $player = Player::getInstance();
        if ($param == 'all') {
            $items = $player->getInventoryList();
            if (empty($items)) {
                return 'Nothing to drop';
            }
            $messages = array();
            foreach ($items as $itemId => $item) {
                array_push($messages, $player->dropItem($itemId));
            }
            return implode("\n", $messages);
        }
        return $player->dropItem($param);
    }



}
