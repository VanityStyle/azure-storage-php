<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

use AzureOss\Storage\Blob\Helpers\DeprecationHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class BlobDownloadStreamingResult
{
    /**
     * @readonly
     */
    public StreamInterface $content;
    /**
     * @readonly
     */
    public BlobProperties $properties;
    /**
     * @deprecated will be private in version 2
     */
    public function __construct(
        StreamInterface $content,
        BlobProperties $properties
    ) {
        $this->content = $content;
        $this->properties = $properties;
        DeprecationHelper::constructorWillBePrivate(self::class, '2.0');
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        /** @phpstan-ignore-next-line */
        return new self(
            $response->getBody(),
            BlobProperties::fromResponseHeaders($response),
        );
    }
}
