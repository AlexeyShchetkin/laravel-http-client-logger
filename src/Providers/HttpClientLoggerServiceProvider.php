<?php

declare(strict_types=1);

namespace AlexeyShchetkin\LaravelHttpClientLogger\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use AlexeyShchetkin\LaravelHttpClientLogger\ValueObjects\HttpClientLoggerConfiguration;

final class HttpClientLoggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(HttpClientLoggerConfiguration::class, function () {
            return HttpClientLoggerConfiguration::loadFromConfig();
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config' => config_path(),
            ], 'laravel-http-client-logger');
        }
        $configuration = app(HttpClientLoggerConfiguration::class);
        if (!empty($configuration->getChannelName()) && !empty($configuration->getChannelConfiguration())) {
            app('config')->set(
                'logging.channels.' . $configuration->getChannelName(),
                $configuration->getChannelConfiguration()
            );
            foreach ($configuration->getEvents() as $event => $listener) {
                Event::listen($event, $listener);
            }
        }
    }
}
