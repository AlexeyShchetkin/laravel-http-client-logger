# Laravel Http Client Logger

Laravel Http Client Logger - library for logging connection/request/response actions for Laravel HTTP Client

## Installation

You can install the package via composer:

```bash
composer require alexeyshchetkin/laravel-http-client-logger
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="AlexeyShchetkin\LaravelHttpClientLogger\Providers\HttpClientLoggerServiceProvider" --tag="laravel-http-client-logger"
```

The contents of the published config file:

```php
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
```

## License

The MIT License (MIT).
