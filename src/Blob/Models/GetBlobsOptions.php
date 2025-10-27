<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Models;

final class GetBlobsOptions
{
    public ?int $pageSize = null;
    public function __construct(?int $pageSize = null)
    {
        $this->pageSize = $pageSize;
    }
}
