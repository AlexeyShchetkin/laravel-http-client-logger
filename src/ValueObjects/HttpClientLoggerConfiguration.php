<?php

declare(strict_types=1);

namespace AlexeyShchetkin\LaravelHttpClientLogger\ValueObjects;

final class HttpClientLoggerConfiguration
{
    private string $channelName = 'external_requests';
    private array $channelConfiguration = [];
    private array $events = [];
    private string $logLevel = 'info';

    private function __construct()
    {
    }

    public static function loadFromConfig(string $configName = 'laravel_http_client_logger'): self
    {
        $configuration = new self();
        $configuration->logLevel = config($configName . '.log_level', 'info');
        $configuration->channelName = config($configName . '.channel_name', 'external_requests');
        $configuration->channelConfiguration = config($configName . '.channel_configuration', []);
        $configuration->events = config($configName . '.events', []);
        return $configuration;
    }

    /**
     * @return string
     */
    public function getChannelName(): string
    {
        return $this->channelName;
    }

    /**
     * @return array
     */
    public function getChannelConfiguration(): array
    {
        return $this->channelConfiguration;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return string
     */
    public function getLogLevel(): string
    {
        return $this->logLevel;
    }
}
