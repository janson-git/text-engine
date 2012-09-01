<?php

return array(
    'rooms' => array(
        'northRoom' => array(
            'id' => 'northRoom',
            'startRoom' => true,
            'doors' => array(
                'south' => 'southRoom',
            ),
            'description' => "It's a north room of tower. Old prison for political prisoners.",
            'items' => array(
                'test_box' => array(
                    'id' => 'test_box',
                    'description' => 'A little test box. When you try to shake it - you can hear some noise.'
                ),
            ),
        ),
        'southRoom' => array(
            'id' => 'southRoom',
            'doors' => array(
                'north' => 'northRoom',
            ),
            'description' => "Nice room with orange walls. Warm wind blows from ventilation on top.",
        ),
    ),
);