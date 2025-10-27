<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Auth;

final class AccessToken
{
    /**
     * @readonly
     */
    public string $accessToken;
    /**
     * @readonly
     */
    public \DateTimeInterface $expiresOn;
    public function __construct(string $accessToken, \DateTimeInterface $expiresOn)
    {
        $this->accessToken = $accessToken;
        $this->expiresOn = $expiresOn;
    }
}
