<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

final class UploadBlobOptions
{
    public ?string $contentType = null;
    /**
     * @var int
     */
    public int $initialTransferSize = 256_000_000;
    /**
     * @var int
     */
    public int $maximumTransferSize = 8_000_000;
    /**
     * @var int
     */
    public int $maximumConcurrency = 25;
    /**
     * @readonly
     */
    public BlobHttpHeaders $httpHeaders;

    /**
     * @param int $initialTransferSize The size of the first range request in bytes. Blobs smaller than this limit will be transferred in a single request. Blobs larger than this limit will continue being transferred in chunks of size MaximumTransferSize.
     * @param int $maximumTransferSize The maximum length of a transfer in bytes.
     * @param int $maximumConcurrency The maximum number of workers that may be used in a parallel transfer.
     */
    public function __construct(
        ?string $contentType = null,
        int $initialTransferSize = 256_000_000,
        int $maximumTransferSize = 8_000_000,
        int $maximumConcurrency = 25,
        ?BlobHttpHeaders $httpHeaders = null
    ) {
        $this->contentType = $contentType;
        $this->initialTransferSize = $initialTransferSize;
        $this->maximumTransferSize = $maximumTransferSize;
        $this->maximumConcurrency = $maximumConcurrency;
        $this->httpHeaders = $httpHeaders ?? new BlobHttpHeaders();

        if ($this->httpHeaders->contentType === "" && $contentType !== null) {
            $this->httpHeaders->contentType = $contentType;
        }
    }
}
