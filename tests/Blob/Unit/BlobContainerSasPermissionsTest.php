<?php

declare(strict_types=1);

namespace AzureOss\Storage\Tests\Blob\Unit;

use AzureOss\Storage\Blob\Sas\BlobContainerSasPermissions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BlobContainerSasPermissionsTest extends TestCase
{
    public function to_string_works(): void
    {
        $permissions = new BlobContainerSasPermissions();
        self::assertEquals("", (string) $permissions);
        $permissions = new BlobContainerSasPermissions(true, false, false, false, true);
        self::assertEquals("rd", (string) $permissions);
        $permissions = new BlobContainerSasPermissions(
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
        self::assertEquals("racwdxlfmeopi", (string) $permissions);
    }
}
