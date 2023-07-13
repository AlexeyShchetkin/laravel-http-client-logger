<?php

declare(strict_types=1);

namespace AlexeyShchetkin\LaravelHttpClientLogger\Listeners;

use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use AlexeyShchetkin\LaravelHttpClientLogger\ValueObjects\HttpClientLoggerConfiguration;

class ResponseReceivedListener
{
    private HttpClientLoggerConfiguration $configuration;

    public function __construct(HttpClientLoggerConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function handle(ResponseReceived $event)
    {
        $request = $event->request;
        $response = $event->response;

        rescue(
            fn() => Log::channel($this->configuration->getChannelName())->log(
                $this->configuration->getLogLevel(),
                'Response for url: ' . $request->url(),
                $this->generateLogMessage($request, $response),
            )
        );
    }

    private function generateLogMessage(Request $request, Response $response): array
    {
        return [
            'url' => $request->url(),
            'method' => $request->method(),
            'status' => $response->status(),
            'request' => [
                'headers' => $request->headers(),
                'payload' => $request->data(),
            ],
            'response' => [
                'headers' => $response->headers(),
                'namelookup_time' => $response->handlerStats()['namelookup_time'],
                'pretransfer_time' => $response->handlerStats()['pretransfer_time'],
                'starttransfer_time' => $response->handlerStats()['starttransfer_time'],
                'connect_time' => $response->handlerStats()['connect_time'],
                'total_time' => $response->handlerStats()['total_time'],
                'redirect_time' => $response->handlerStats()['redirect_time'],
                'redirect_count' => $response->handlerStats()['redirect_count'],
                'size_download' => $response->handlerStats()['size_download'],
            ],
        ];
    }
}
