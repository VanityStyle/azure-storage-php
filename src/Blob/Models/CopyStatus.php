<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

class CopyStatus
{
    public const PENDING = 'pending';
    public const SUCCESS = 'success';
    public const ABORTED = 'aborted';
    public const FAILED = 'failed';
}
