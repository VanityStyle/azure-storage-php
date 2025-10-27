<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Middleware;

final class HttpClientOptions
{
    /**
     * @readonly
     */
    public ?int $timeout = null;
    /**
     * @readonly
     */
    public ?int $connectTimeout = null;
    public function __construct(?int $timeout = null, ?int $connectTimeout = null)
    {
        $this->timeout = $timeout;
        $this->connectTimeout = $connectTimeout;
    }

    /**
     * @return array{timeout?: int, connect_timeout?: int}
     */
    public function toGuzzleHttpClientConfig(): array
    {
        return array_filter([
            'timeout' => $this->timeout,
            'connect_timeout' => $this->connectTimeout,
        ], fn($value) => $value !== null);
    }
}
