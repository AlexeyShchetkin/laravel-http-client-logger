<?php

use AlexeyShchetkin\LaravelHttpClientLogger\Listeners\ConnectionFailedListener;
use AlexeyShchetkin\LaravelHttpClientLogger\Listeners\RequestSendingListener;
use AlexeyShchetkin\LaravelHttpClientLogger\Listeners\ResponseReceivedListener;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Events\ResponseReceived;
use Monolog\Formatter\JsonFormatter;

return [
    /*
     * Channel name for logging
     */
    'channel_name' => 'external_requests',
    /*
     * Channel log level
     */
    'log_level' => 'info',
    /*
     * Channel configuration in Laravel style
     */
    'channel_configuration' => [
        'driver' => 'daily',
        'path' => storage_path('logs/external_requests.log'),
        'formatter' => JsonFormatter::class,
        'level' => env('LOG_LEVEL', 'info'),
        'days' => 7,
    ],
    /*
     * Http client events for logging (comment not needed, add own if needed)
     */
    'events' => [
        ConnectionFailed::class => ConnectionFailedListener::class,
        RequestSending::class => RequestSendingListener::class,
        ResponseReceived::class => ResponseReceivedListener::class,
    ],
];
