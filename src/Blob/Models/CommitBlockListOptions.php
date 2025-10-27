<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

final class CommitBlockListOptions
{
    /**
     * @readonly
     */
    public BlobHttpHeaders $httpHeaders;

    public function __construct(
        ?BlobHttpHeaders $httpHeaders = null
    ) {
        $this->httpHeaders = $httpHeaders ?? new BlobHttpHeaders();
    }
}
