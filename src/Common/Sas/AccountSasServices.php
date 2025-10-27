<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Sas;

final class AccountSasServices
{
    public bool $blob = false;
    public bool $queue = false;
    public bool $table = false;
    public bool $file = false;
    public function __construct(bool $blob = false, bool $queue = false, bool $table = false, bool $file = false)
    {
        $this->blob = $blob;
        $this->queue = $queue;
        $this->table = $table;
        $this->file = $file;
    }

    public function __toString(): string
    {
        $permissions = "";

        if ($this->blob) {
            $permissions .= "b";
        }
        if ($this->queue) {
            $permissions .= "q";
        }
        if ($this->table) {
            $permissions .= "t";
        }
        if ($this->file) {
            $permissions .= "f";
        }

        return $permissions;
    }
}
