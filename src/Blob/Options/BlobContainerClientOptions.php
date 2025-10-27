<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Options;

use AzureOss\Storage\Common\Middleware\HttpClientOptions;

final class BlobContainerClientOptions
{
    /**
     * @readonly
     */
    public HttpClientOptions $httpClientOptions;
    public function __construct(?HttpClientOptions $httpClientOptions = null)
    {
        $httpClientOptions ??= new HttpClientOptions();
        $this->httpClientOptions = $httpClientOptions;
    }
}
