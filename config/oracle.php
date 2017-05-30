<?php

return [
    'oracle' => [
        'driver'        => 'oracle',
        'tns'           => env('DB_TNS', ''),
        'host'          => env('DB_HOST', '172.25.52.22'),
        'port'          => env('DB_PORT', '1521'),
        'database'      => env('DB_DATABASE', 'LEODB'),
        'username'      => env('DB_USERNAME', 'MOB'),
        'password'      => env('DB_PASSWORD', 'MOB'),
        'charset'       => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'        => env('DB_PREFIX', ''),
        'prefix_schema' => env('DB_SCHEMA_PREFIX', ''),
    ],
];
