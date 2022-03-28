<?php

return [
    'postman' => [
        'token' => env('POSTMAN_API_TOKEN'),
    ],
    // 全局返回格式
    'global_response' => [
        'exclude' => [
            'horizon/*',
            'laravel-websockets/*',
            'broadcasting/*',
            '*/export/*',
            '*/pusher/auth',
            '*/pusher/auth',
            'web/*',
        ]
    ],
];
