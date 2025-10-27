<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Requests;

/**
 * @internal
 */
final class PutBlockRequestBody
{
    /**
     * @var string[]
     */
    public array $base64BlockIds;
    /**
     * @param string[] $base64BlockIds
     */
    public function __construct(array $base64BlockIds)
    {
        $this->base64BlockIds = $base64BlockIds;
    }

    public function toXml(): \SimpleXMLElement
    {
        $xml = new \SimpleXMLElement("<BlockList></BlockList>");

        foreach ($this->base64BlockIds as $base64BlockId) {
            $xml->addChild("Latest", $base64BlockId);
        }

        return $xml;
    }
}
