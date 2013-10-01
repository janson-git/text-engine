<?php

return [
    'rooms' => [
        'northRoom' => [
            'id' => 'northRoom',
            'startRoom' => true,
            'doors' => [
                'south' => 'southRoom',
                'north' => 'magicRoom',
            ],
            'description' => "It's a north room of tower. Old prison for political prisoners.",
            'items' => [
                'magic box' => [
                    'id'          => 'magic box',
                    'description' => 'A little magic box. When you try to shake it - you can hear some noise.',
                    'type'        => 'item',
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
                'sword' => [
                    'id'          => 'sword',
                    'description' => 'A little sharp sword.',
                    'type'        => 'weapon',
                ],
            ],
        ],

        'magicRoom' => [
            'id' => 'magicRoom',
            'doors' => [
                'east' => 'northRoom',
                'west' => 'northRoom',
            ],
            'description' => "Dark room. Shadows, craps and bugs here. Smells like magic.",
            'items' => [
                'book' => [
                    'id'          => 'book',
                    'description' => 'Book. Probably this is magic book.',
                    'type'        => 'item',
                ],
            ],
        ],
    ],
];