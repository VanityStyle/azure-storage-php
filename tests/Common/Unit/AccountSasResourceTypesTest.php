<?php

declare(strict_types=1);

namespace AzureOss\Storage\Tests\Common\Unit;

use AzureOss\Storage\Common\Sas\AccountSasResourceTypes;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AccountSasResourceTypesTest extends TestCase
{
    public function to_string_works(): void
    {
        $resource = new AccountSasResourceTypes();
        self::assertEquals("", (string) $resource);
        $resource = new AccountSasResourceTypes(false, true);
        self::assertEquals("c", (string) $resource);
        $resource = new AccountSasResourceTypes(true, true, true);
        self::assertEquals("sco", (string) $resource);
    }
}
