<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Responses;

use AzureOss\Storage\Blob\Models\BlobContainer;

/**
 * @internal
 */
final class ListContainersResponseBody
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
     * @var BlobContainer[]
     * @readonly
     */
    public array $containers;
    /**
     * @param BlobContainer[] $containers
     */
    private function __construct(string $prefix, string $marker, int $maxResults, string $nextMarker, array $containers)
    {
        $this->prefix = $prefix;
        $this->marker = $marker;
        $this->maxResults = $maxResults;
        $this->nextMarker = $nextMarker;
        $this->containers = $containers;
    }

    public static function fromXml(\SimpleXMLElement $xml): self
    {
        $containers = [];
        foreach ($xml->Containers->children() as $container) {
            $containers[] = BlobContainer::fromXml($container);
        }

        return new self(
            (string) $xml->Prefix,
            (string) $xml->Marker,
            (int) $xml->MaxResults,
            (string) $xml->NextMarker,
            $containers,
        );
    }
}
