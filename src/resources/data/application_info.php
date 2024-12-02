<?php

return [
    'application' => [
        'app_name'    => env('APP_NAME'),
        'app_version' => env('APP_VERSION'),
        'migrate_version' => env('MIGRATE_VERSION'),
    ],
    'requirements' => [
        'php' => [
            'Core',
            'bcmath',
            'openssl',
            'pdo_mysql',
            'mbstring',
            'tokenizer',
            'json',
            'curl',
            'gd',
            'zip',
        ],
    ],
    'permissions' => [
        '.env' => '666',
        'storage' => '775',
        'bootstrap/cache/' => '775',
    ],
];
