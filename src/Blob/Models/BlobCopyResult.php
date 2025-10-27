<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

use Psr\Http\Message\ResponseInterface;

final class BlobCopyResult
{
    /**
     * @readonly
     */
    public string $copyId;
    /**
     * @readonly
     */
    public string $copyStatus;
    private function __construct(string $copyId, string $copyStatus)
    {
        $this->copyId = $copyId;
        $this->copyStatus = $copyStatus;
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        return new self(
            $response->getHeaderLine('x-ms-copy-id'),
            $response->getHeaderLine('x-ms-copy-status'),
        );
    }
}
