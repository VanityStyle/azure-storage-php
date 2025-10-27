<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

use AzureOss\Storage\Blob\Helpers\DeprecationHelper;

final class Blob
{
    /**
     * @readonly
     */
    public string $name;
    /**
     * @readonly
     */
    public BlobProperties $properties;
    /**
     * @deprecated will be private in version 2
     */
    public function __construct(
        string         $name,
        BlobProperties $properties
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
            BlobProperties::fromXml($xml->Properties),
        );
    }
}
