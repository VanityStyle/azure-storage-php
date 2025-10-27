<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Sas;

use AzureOss\Storage\Blob\Helpers\DateHelper;
use AzureOss\Storage\Common\ApiVersion;
use AzureOss\Storage\Common\Auth\StorageSharedKeyCredential;
use GuzzleHttp\Psr7\Query;

final class AccountSasBuilder
{
    private string $version;

    private string $services;

    private string $resourceTypes;

    private string $permissions;

    private ?\DateTimeInterface $startsOn = null;

    private \DateTimeInterface $expiresOn;

    private ?SasIpRange $ipRange = null;

    private ?SasProtocol $protocol = null;

    private ?string $encryptionScope = null;

    public static function new(): self
    {
        return new self();
    }

    public function setVersion(string $version): AccountSasBuilder
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param string|\AzureOss\Storage\Common\Sas\AccountSasServices $services
     */
    public function setServices($services): AccountSasBuilder
    {
        $this->services = (string) $services;

        return $this;
    }

    /**
     * @param string|\AzureOss\Storage\Common\Sas\AccountSasResourceTypes $resourceTypes
     */
    public function setResourceTypes($resourceTypes): AccountSasBuilder
    {
        $this->resourceTypes = (string) $resourceTypes;

        return $this;
    }

    /**
     * @param string|\AzureOss\Storage\Common\Sas\AccountSasPermissions $permissions
     */
    public function setPermissions($permissions): AccountSasBuilder
    {
        $this->permissions = (string) $permissions;

        return $this;
    }

    public function setStartsOn(\DateTimeInterface $startsOn): AccountSasBuilder
    {
        $this->startsOn = $startsOn;

        return $this;
    }

    public function setExpiresOn(\DateTimeInterface $expiresOn): AccountSasBuilder
    {
        $this->expiresOn = $expiresOn;

        return $this;
    }

    public function setIpRange(SasIpRange $ipRange): AccountSasBuilder
    {
        $this->ipRange = $ipRange;

        return $this;
    }

    public function setProtocol(SasProtocol $protocol): AccountSasBuilder
    {
        $this->protocol = $protocol;

        return $this;
    }

    public function setEncryptionScope(string $encryptionScope): AccountSasBuilder
    {
        $this->encryptionScope = $encryptionScope;

        return $this;
    }

    public function build(StorageSharedKeyCredential $sharedKeyCredential): string
    {
        $signedStart = $this->startsOn !== null ? DateHelper::formatAs8601Zulu($this->startsOn) : null;
        $signedExpiry = DateHelper::formatAs8601Zulu($this->expiresOn);
        $signedIp = $this->ipRange !== null ? (string) $this->ipRange : null;
        $signedProtocol = ($nullsafeVariable1 = $this->protocol) ? $nullsafeVariable1->value : null;
        $signedVersion = $this->version ?? ApiVersion::LATEST;

        $stringToSign = [
            $sharedKeyCredential->accountName,
            $this->permissions,
            $this->services,
            $this->resourceTypes,
            $signedStart,
            $signedExpiry,
            $signedIp,
            $signedProtocol,
            $signedVersion,
            $this->encryptionScope,
        ];
        $stringToSign = array_map(fn($str) => urldecode($str ?? ""), $stringToSign);
        $stringToSign = implode("\n", $stringToSign) . "\n";

        $signature = urlencode($sharedKeyCredential->computeHMACSHA256($stringToSign));

        return Query::build(array_filter([
            "sv" => $signedVersion,
            "ss" => $this->services,
            "srt" => $this->resourceTypes,
            "sp" => $this->permissions,
            "st" => $signedStart,
            "se" => $signedExpiry,
            "sip" => $signedIp,
            "spr" => $signedProtocol,
            "ses" => $this->encryptionScope,
            "sig" => $signature,
        ], fn(?string $value) => $value !== null), false);
    }
}
