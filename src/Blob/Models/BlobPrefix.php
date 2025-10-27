<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

use AzureOss\Storage\Blob\Helpers\DeprecationHelper;

/**
 * @internal
 */
final class BlobPrefix
{
    /**
     * @readonly
     */
    public string $name;
    /**
     * @deprecated will be private in version 2
     */
    public function __construct(
        string $name
    ) {
        $this->name = $name;
        DeprecationHelper::constructorWillBePrivate(self::class, '2.0');
    }

    public static function fromXml(\SimpleXMLElement $xml): self
    {
        /** @phpstan-ignore-next-line */
        return new self(
            (string) $xml->Name,
        );
    }
}
