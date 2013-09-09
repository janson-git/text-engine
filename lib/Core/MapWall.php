<?php

namespace Core;

class MapWall extends MapSite
{
    public function __construct() {}

    /**
     * @return string
     */
    public function enter()
    {
        return 'Oops! You can\'t go throuh walls!';
    }
}
