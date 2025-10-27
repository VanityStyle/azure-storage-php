<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Middleware;

use AzureOss\Storage\Common\ApiVersion;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 */
final class AddXMsVersionMiddleware
{
    private string $version;
    public function __construct(string $version)
    {
        $this->version = $version;
    }

    public function __invoke(callable $handler): \Closure
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $request = $request->withHeader('x-ms-version', $this->version);

            return $handler($request, $options);
        };
    }
}
