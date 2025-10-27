<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Responses;

use AzureOss\Storage\Blob\Models\TaggedBlob;
use SimpleXMLElement;

/**
 * @internal
 */
final class FindBlobsByTagBody
{
    /**
     * @var string
     * @readonly
     */
    public string $nextMarker;
    /**
     * @var TaggedBlob[]
     * @readonly
     */
    public array $blobs;
    /**
     * @param string $nextMarker
     * @param TaggedBlob[] $blobs
     */
    private function __construct(string $nextMarker, array $blobs)
    {
        $this->nextMarker = $nextMarker;
        $this->blobs = $blobs;
    }

    public static function fromXml(SimpleXMLElement $xml): self
    {
        $blobs = [];

        foreach ($xml->Blobs->children() as $blob) {
            $blobs[] = TaggedBlob::fromXml($blob);
        }

        return new self(
            (string) $xml->NextMarker,
            $blobs,
        );
    }
}
