<?php

declare(strict_types=1);

namespace AzureOss\Storage\Tests\Common\Unit;

use AzureOss\Storage\Common\Sas\AccountSasServices;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AccountSasServicesTest extends TestCase
{
    public function to_string_works(): void
    {
        $services = new AccountSasServices();
        self::assertEquals("", (string) $services);
        $services = new AccountSasServices(false, true);
        self::assertEquals("q", (string) $services);
        $services = new AccountSasServices(true, true, true, true);
        self::assertEquals("bqtf", (string) $services);
    }
}
