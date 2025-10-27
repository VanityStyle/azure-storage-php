<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

use AzureOss\Storage\Blob\Helpers\DeprecationHelper;

final class TaggedBlob
{
    /**
     * @readonly
     */
    public string $name;
    /**
     * @readonly
     */
    public string $containerName;
    /**
     * @var array<string>
     * @readonly
     */
    public array $tags;
    /**
     * @deprecated will be private in version 2
     * @param array<string> $tags
     */
    public function __construct(
        string $name,
        string $containerName,
        array $tags
    ) {
        $this->name = $name;
        $this->containerName = $containerName;
        $this->tags = $tags;
        DeprecationHelper::constructorWillBePrivate(self::class, '2.0');
    }

    public static function fromXml(\SimpleXMLElement $xml): self
    {
        $tags = [];
        foreach ($xml->Tags->TagSet->children() as $tag) {
            $tags[(string) $tag->Key] = (string) $tag->Value;
        }

        /** @phpstan-ignore-next-line */
        return new self(
            (string) $xml->Name,
            (string) $xml->ContainerName,
            $tags,
        );
    }
}
