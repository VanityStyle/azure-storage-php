<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Responses;

use AzureOss\Storage\Blob\Models\Blob;
use AzureOss\Storage\Blob\Models\BlobPrefix;

/**
 * @internal
 */
final class ListBlobsResponseBody
{
    /**
     * @readonly
     */
    public string $prefix;
    /**
     * @readonly
     */
    public string $marker;
    /**
     * @readonly
     */
    public int $maxResults;
    /**
     * @readonly
     */
    public string $nextMarker;
    /**
     * @var Blob[]
     * @readonly
     */
    public array $blobs;
    /**
     * @var BlobPrefix[]
     * @readonly
     */
    public array $blobPrefixes;
    /**
     * @readonly
     */
    public ?string $delimiter = null;
    /**
     * @param  Blob[]  $blobs
     * @param  BlobPrefix[]  $blobPrefixes
     */
    private function __construct(string $prefix, string $marker, int $maxResults, string $nextMarker, array $blobs, array $blobPrefixes, ?string $delimiter = null)
    {
        $this->prefix = $prefix;
        $this->marker = $marker;
        $this->maxResults = $maxResults;
        $this->nextMarker = $nextMarker;
        $this->blobs = $blobs;
        $this->blobPrefixes = $blobPrefixes;
        $this->delimiter = $delimiter;
    }

    public static function fromXml(\SimpleXMLElement $xml): self
    {
        $blobs = [];
        $blobPrefixes = [];

        foreach ($xml->Blobs->children() as $blobOrPrefix) {
            switch ($blobOrPrefix->getName()) {
                case 'Blob':
                    $blobs[] = Blob::fromXml($blobOrPrefix);
                    break;
                case 'BlobPrefix':
                    $blobPrefixes[] = BlobPrefix::fromXml($blobOrPrefix);
                    break;
            }
        }

        return new self(
            (string) $xml->Prefix,
            (string) $xml->Marker,
            (int) $xml->MaxResults,
            (string) $xml->NextMarker,
            $blobs,
            $blobPrefixes,
            (string) $xml->Delimiter,
        );
    }
}
