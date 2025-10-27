<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

use AzureOss\Storage\Blob\Helpers\DeprecationHelper;

final class BlobContainer
{
    /**
     * @readonly
     */
    public string $name;
    /**
     * @readonly
     */
    public BlobContainerProperties $properties;
    /**
     * @deprecated will be private in version 2
     */
    public function __construct(
        string $name,
        BlobContainerProperties $properties
    ) {
        $this->name = $name;
        $this->properties = $properties;
        DeprecationHelper::constructorWillBePrivate(self::class, '2.0');
    }

    public static function fromXml(\SimpleXMLElement $xml): self
    {
        /** @phpstan-ignore-next-line */
        return new self(
            (string) $xml->Name,
            BlobContainerProperties::fromXml($xml->Properties),
        );
    }
}
