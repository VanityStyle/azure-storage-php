<?php

declare(strict_types=1);

namespace AzureOss\Storage\Tests\Common\Unit;

use AzureOss\Storage\Common\Sas\AccountSasPermissions;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AccountSasPermissionsTest extends TestCase
{
    public function to_string_works(): void
    {
        $permissions = new AccountSasPermissions();
        self::assertEquals("", (string) $permissions);
        $permissions = new AccountSasPermissions(true, false, true, false, false, true);
        self::assertEquals("rda", (string) $permissions);
        $permissions = new AccountSasPermissions(
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
        self::assertEquals("rwdylacuptfi", (string) $permissions);
    }
}
