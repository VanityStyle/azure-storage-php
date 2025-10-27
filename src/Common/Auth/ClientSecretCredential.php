<?php

declare(strict_types=1);

namespace AzureOss\Storage\Common\Auth;

use DateTimeImmutable;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

/**
 * @see https://learn.microsoft.com/en-us/rest/api/storageservices/authorize-with-azure-active-directory
 */
final class ClientSecretCredential implements TokenCredential
{
    /**
     * @readonly
     */
    private string $tenantId;
    /**
     * @readonly
     */
    private string $clientId;
    /**
     * @readonly
     */
    private string $clientSecret;
    public function __construct(string $tenantId, string $clientId, string $clientSecret)
    {
        $this->tenantId = $tenantId;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getToken(): AccessToken
    {
        $client = new Client();

        $response = $client->post("https://login.microsoftonline.com/{$this->tenantId}/oauth2/token", [
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            RequestOptions::FORM_PARAMS => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'resource' => 'https://storage.azure.com/',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if (! is_array($data) ||
            ! array_key_exists('access_token', $data) ||
            ! is_string($data['access_token']) ||
            ! array_key_exists('expires_on', $data) ||
            ! is_numeric($data['expires_on'])
        ) {
            throw new \RuntimeException('Unexpected response from Azure');
        }

        return new AccessToken(
            $data['access_token'],
            (new DateTimeImmutable())->setTimestamp((int) $data['expires_on']),
        );
    }
}
