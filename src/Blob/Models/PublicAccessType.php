<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

class PublicAccessType
{
    public const NONE = 'none';
    public const BLOB = 'blob';
    public const CONTAINER = 'container';
}
