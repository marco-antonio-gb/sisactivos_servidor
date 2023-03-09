<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */
    'default' => env('LOG_CHANNEL', 'stack'),
    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */
    'channels' => [
        'login_usuarios' => [
            'driver' => 'daily',
            'path' => public_path('home/logs/login/login_usuarios.log'),
            'level' => 'info',
        ],
        'password_reset' => [
            'driver' => 'daily',
            'path' => public_path('home/logs/password_reset/password_reset.log'),
            'level' => 'info',
        ],
        'registro_usuarios' => [
            'driver' => 'daily',
            'path' => public_path('home/logs/usuarios/registro_usuarios.log'),
            'level' => 'info',
        ],
        'registro_articulos' => [
            'driver' => 'daily',
            'path' => public_path('home/logs/articulos/registro_articulos.log'),
            'level' => 'info',
        ],
        'registro_bajas' => [
            'driver' => 'daily',
            'path' => public_path('home/logs/bajas/registrao_bajas.log'),
            'level' => 'info',
        ],
        'registro_asignaciones' => [
            'driver' => 'daily',
            'path' => public_path('home/logs/asignaciones/registro_asignaciones.log'),
            'level' => 'info',
        ],
        'registro_transferencias' => [
            'driver' => 'daily',
            'path' => public_path('home/logs/transferencias/registro_transferencias.log'),
            'level' => 'info',
        ],
        'registro_responsables' => [
            'driver' => 'daily',
            'path' => public_path('home/logs/responsables/registro_responsables.log'),
            'level' => 'info',
        ],
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],
        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],
        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],
        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],
        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],
];
