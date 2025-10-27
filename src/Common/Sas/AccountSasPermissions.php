<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Sas;

final class AccountSasPermissions
{
    /**
     * @readonly
     */
    public bool $read = false;
    /**
     * @readonly
     */
    public bool $write = false;
    /**
     * @readonly
     */
    public bool $delete = false;
    /**
     * @readonly
     */
    public bool $permanentDelete = false;
    /**
     * @readonly
     */
    public bool $list = false;
    /**
     * @readonly
     */
    public bool $add = false;
    /**
     * @readonly
     */
    public bool $create = false;
    /**
     * @readonly
     */
    public bool $update = false;
    /**
     * @readonly
     */
    public bool $process = false;
    /**
     * @readonly
     */
    public bool $tags = false;
    /**
     * @readonly
     */
    public bool $filter = false;
    /**
     * @readonly
     */
    public bool $setImmutabilityPolicy = false;
    public function __construct(bool $read = false, bool $write = false, bool $delete = false, bool $permanentDelete = false, bool $list = false, bool $add = false, bool $create = false, bool $update = false, bool $process = false, bool $tags = false, bool $filter = false, bool $setImmutabilityPolicy = false)
    {
        $this->read = $read;
        $this->write = $write;
        $this->delete = $delete;
        $this->permanentDelete = $permanentDelete;
        $this->list = $list;
        $this->add = $add;
        $this->create = $create;
        $this->update = $update;
        $this->process = $process;
        $this->tags = $tags;
        $this->filter = $filter;
        $this->setImmutabilityPolicy = $setImmutabilityPolicy;
    }

    public function __toString(): string
    {
        $permissions = "";

        if ($this->read) {
            $permissions .= "r";
        }
        if ($this->write) {
            $permissions .= "w";
        }
        if ($this->delete) {
            $permissions .= "d";
        }
        if ($this->permanentDelete) {
            $permissions .= "y";
        }
        if ($this->list) {
            $permissions .= "l";
        }
        if ($this->add) {
            $permissions .= "a";
        }
        if ($this->create) {
            $permissions .= "c";
        }
        if ($this->update) {
            $permissions .= "u";
        }
        if ($this->process) {
            $permissions .= "p";
        }
        if ($this->tags) {
            $permissions .= "t";
        }
        if ($this->filter) {
            $permissions .= "f";
        }
        if ($this->setImmutabilityPolicy) {
            $permissions .= "i";
        }

        return $permissions;
    }
}
