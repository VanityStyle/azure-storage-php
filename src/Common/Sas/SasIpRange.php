<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Sas;

final class SasIpRange
{
    /**
     * @readonly
     */
    public string $start;
    /**
     * @readonly
     */
    public ?string $end = null;
    public function __construct(string $start, ?string $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function __toString(): string
    {
        return $this->end === null
            ? $this->start
            : $this->start . "-" . $this->end;
    }
}
