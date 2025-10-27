<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

use AzureOss\Storage\Blob\Helpers\DateHelper;
use AzureOss\Storage\Blob\Helpers\DeprecationHelper;
use AzureOss\Storage\Blob\Helpers\HashHelper;
use AzureOss\Storage\Blob\Helpers\MetadataHelper;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

final class BlobProperties
{
    /**
     * @readonly
     */
    public \DateTimeInterface $lastModified;
    /**
     * @readonly
     */
    public int $contentLength;
    /**
     * @readonly
     */
    public string $contentType;
    /**
     * @readonly
     */
    public ?string $contentMD5;
    /**
     * @var array<string>
     * @readonly
     */
    public array $metadata;
    /**
     * @readonly
     */
    public ?string $copyId = null;
    /**
     * @readonly
     */
    public ?UriInterface $copySource = null;
    /**
     * @readonly
     */
    public ?string $copyStatus = null;
    /**
     * @readonly
     */
    public ?string $copyStatusDescription = null;
    /**
     * @readonly
     */
    public ?\DateTimeInterface $copyCompletionTime = null;
    /**
     * @readonly
     */
    public string $cacheControl = "";
    /**
     * @readonly
     */
    public string $contentDisposition = "";
    /**
     * @readonly
     */
    public string $contentLanguage = "";
    /**
     * @readonly
     */
    public string $contentEncoding = "";
    /**
     * @deprecated will be private in version 2
     * @param array<string> $metadata
    */
    public function __construct(
        \DateTimeInterface $lastModified,
        int $contentLength,
        string $contentType,
        ?string $contentMD5,
        array $metadata,
        ?string $copyId = null,
        ?UriInterface $copySource = null,
        ?string $copyStatus = null,
        ?string $copyStatusDescription = null,
        ?\DateTimeInterface $copyCompletionTime = null,
        string $cacheControl = "",
        string $contentDisposition = "",
        string $contentLanguage = "",
        string $contentEncoding = ""
    ) {
        $this->lastModified = $lastModified;
        $this->contentLength = $contentLength;
        $this->contentType = $contentType;
        $this->contentMD5 = $contentMD5;
        $this->metadata = $metadata;
        $this->copyId = $copyId;
        $this->copySource = $copySource;
        $this->copyStatus = $copyStatus;
        $this->copyStatusDescription = $copyStatusDescription;
        $this->copyCompletionTime = $copyCompletionTime;
        $this->cacheControl = $cacheControl;
        $this->contentDisposition = $contentDisposition;
        $this->contentLanguage = $contentLanguage;
        $this->contentEncoding = $contentEncoding;
        DeprecationHelper::constructorWillBePrivate(self::class, '2.0');
    }

    public static function fromResponseHeaders(ResponseInterface $response): self
    {
        /** @phpstan-ignore-next-line */
        return new BlobProperties(
            DateHelper::deserializeDateRfc1123Date($response->getHeaderLine('Last-Modified')),
            $response->getHeaderLine('x-encoded-content-length') !== "" ? (int) $response->getHeaderLine('x-encoded-content-length') : (int) $response->getHeaderLine('Content-Length'),
            $response->getHeaderLine('Content-Type'),
            HashHelper::deserializeMd5($response->getHeaderLine('Content-MD5')),
            MetadataHelper::headersToMetadata($response->getHeaders()),
            $response->hasHeader('x-ms-copy-id') ? $response->getHeaderLine('x-ms-copy-id') : null,
            $response->hasHeader('x-ms-copy-source') ? new Uri($response->getHeaderLine('x-ms-copy-source')) : null,
            $response->hasHeader('x-ms-copy-status') ? $response->getHeaderLine('x-ms-copy-status') : null,
            $response->hasHeader('x-ms-copy-status-description') ? $response->getHeaderLine('x-ms-copy-status-description') : null,
            $response->hasHeader('x-ms-copy-completion-time') ? DateHelper::deserializeDateRfc1123Date($response->getHeaderLine('x-ms-copy-completion-time')) : null,
            $response->getHeaderLine('Cache-Control'),
            $response->getHeaderLine('Content-Disposition'),
            $response->getHeaderLine('Content-Language'),
            $response->getHeaderLine('x-encoded-content-encoding'),
        );
    }

    public static function fromXml(\SimpleXMLElement $xml): self
    {
        /** @phpstan-ignore-next-line */
        return new self(
            DateHelper::deserializeDateRfc1123Date((string) $xml->{'Last-Modified'}),
            (int) $xml->{'Content-Length'},
            (string) $xml->{'Content-Type'},
            HashHelper::deserializeMd5((string) $xml->{'Content-MD5'}),
            [], // TODO support include metadata
            (string) $xml->CopyId !== "" ? (string) $xml->CopyId : null,
            (string) $xml->CopySource !== "" ? new Uri((string) $xml->CopySource) : null,
            (string) $xml->CopyStatus !== "" ? (string) $xml->CopyStatus : null,
            (string) $xml->CopyStatusDescription !== "" ? (string) $xml->CopyStatusDescription : null,
            (string) $xml->CopyCompletionTime !== "" ? DateHelper::deserializeDateRfc1123Date((string) $xml->CopyCompletionTime) : null,
            (string) $xml->{'Cache-Control'},
            (string) $xml->{'Content-Disposition'},
            (string) $xml->{'Content-Language'},
            (string) $xml->{'Content-Encoding'},
        );
    }

    /**
     * @deprecated will be removed in version 2
     */
    public static function deserializeContentMD5(string $contentMD5): ?string
    {
        DeprecationHelper::methodWillBeRemoved(self::class, __FUNCTION__, '2.0');

        $result = base64_decode($contentMD5, true);
        if ($result === false) {
            return null;
        }

        return bin2hex($result);
    }
}
