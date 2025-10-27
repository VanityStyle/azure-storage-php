<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Middleware;

use GuzzleHttp\Psr7\Query;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 */
final class AddDefaultQueryParamsMiddleware
{
    /**
     * @readonly
     */
    private string $defaultQuery;
    public function __construct(string $defaultQuery)
    {
        $this->defaultQuery = $defaultQuery;
    }

    public function __invoke(callable $handler): \Closure
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $newUri = $request->getUri()->withQuery(
                Query::build(array_merge(Query::parse($this->defaultQuery), Query::parse($request->getUri()->getQuery()))),
            );

            return $handler($request->withUri($newUri), $options);
        };
    }
}
