<?php

return [
    'default' => env('SMS_DRIVER', 'melipayamak'),

    'drivers' => [
        'melipayamak' => [
            'key' => env('MELIPAYAMAK_API_KEY'),
        ],

        'farazsms' => [
            'key' => env('FARAZSMS_API_KEY'),
        ],
    ],
];
