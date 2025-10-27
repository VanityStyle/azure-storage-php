<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Responses;

/**
 * @internal
 */
final class ErrorResponse
{
    /**
     * @readonly
     */
    public string $code;
    /**
     * @readonly
     */
    public string $message;
    public function __construct(string $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public static function fromXml(\SimpleXMLElement $xml): self
    {
        return new self(
            (string) $xml->Code,
            (string) $xml->Message,
        );
    }
}
