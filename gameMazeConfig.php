<?php

return [
    'rooms' => [
        'northRoom' => [
            'id' => 'northRoom',
            'startRoom' => true,
            'doors' => [
                'south' => 'southRoom',
            ],
            'description' => "It's a north room of tower. Old prison for political prisoners.",
            'items' => [
                'test_box' => [
                    'id' => 'test_box',
                    'description' => 'A little test box. When you try to shake it - you can hear some noise.'
                ],
            ],
        ],
        'southRoom' => [
            'id' => 'southRoom',
            'doors' => [
                'north' => 'northRoom',
            ],
            'description' => "Nice room with orange walls. Warm wind blows from ventilation on top.",
            'items' => [
                'test_sword' => [
                    'id' => 'test_sword',
                    'description' => 'A little sharp test sword.'
                ],
            ],
        ],
    ],
];