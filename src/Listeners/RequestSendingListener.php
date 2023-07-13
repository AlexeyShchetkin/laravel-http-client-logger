<?php

declare(strict_types=1);

namespace AlexeyShchetkin\LaravelHttpClientLogger\Listeners;

use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;
use AlexeyShchetkin\LaravelHttpClientLogger\ValueObjects\HttpClientLoggerConfiguration;

class RequestSendingListener
{
    private HttpClientLoggerConfiguration $configuration;

    public function __construct(HttpClientLoggerConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function handle(RequestSending $event)
    {
        $request = $event->request;

        rescue(
            fn() => Log::channel($this->configuration->getChannelName())->log(
                $this->configuration->getLogLevel(),
                'Request for url: ' . $request->url(),
                $this->generateLogMessage($request),
            )
        );
    }

    private function generateLogMessage(Request $request): array
    {
        return [
            'url' => $request->url(),
            'method' => $request->method(),
            'request' => [
                'headers' => $request->headers(),
                'payload' => $request->data(),
            ],
        ];
    }
}
