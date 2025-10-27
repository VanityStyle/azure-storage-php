<?php

declare(strict_types=1);

namespace AzureOss\Storage\Tests\Blob\Unit;

use AzureOss\Storage\Blob\Sas\BlobSasPermissions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BlobSasPermissionsTest extends TestCase
{
    public function to_string_works(): void
    {
        $permissions = new BlobSasPermissions();
        self::assertEquals("", (string) $permissions);
        $permissions = new BlobSasPermissions(true, false, false, false, true);
        self::assertEquals("rd", (string) $permissions);
        $permissions = new BlobSasPermissions(
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
        );
        self::assertEquals("racwdxyltmeopi", (string) $permissions);
    }
}
