<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Sas;

final class AccountSasResourceTypes
{
    public bool $service = false;
    public bool $container = false;
    public bool $object = false;
    public function __construct(bool $service = false, bool $container = false, bool $object = false)
    {
        $this->service = $service;
        $this->container = $container;
        $this->object = $object;
    }

    public function __toString(): string
    {
        $permissions = "";

        if ($this->service) {
            $permissions .= "s";
        }
        if ($this->container) {
            $permissions .= "c";
        }
        if ($this->object) {
            $permissions .= "o";
        }

        return $permissions;
    }
}
