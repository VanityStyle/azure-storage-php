<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

final class CreateContainerOptions
{
    public string $publicAccessType = PublicAccessType::NONE;
    /**
     * @param string $publicAccessType
     */
    public function __construct(string $publicAccessType = PublicAccessType::NONE)
    {
        $this->publicAccessType = $publicAccessType;
    }
}
