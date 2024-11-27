<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'usuarios'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios', // Cambiado de 'users' a 'usuarios'
        ],
    ],

    'providers' => [
        'usuarios' => [ // Cambiado de 'users' a 'usuarios'
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\Usuario::class), // Cambiado a App\Models\Usuario
        ],

        // Si deseas usar la base de datos directamente:
        // 'usuarios' => [
        //     'driver' => 'database',
        //     'table' => 'usuarios',
        // ],
    ],

    'passwords' => [
        'usuarios' => [ // Cambiado de 'users' a 'usuarios'
            'provider' => 'usuarios',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
