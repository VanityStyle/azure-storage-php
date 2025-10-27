<?php

declare(strict_types=1);

namespace AzureOss\Storage\Blob\Exceptions;

use AzureOss\Storage\Blob\Responses\ErrorResponse;
use AzureOss\Storage\Common\Exceptions\RequestExceptionDeserializer;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class BlobStorageExceptionDeserializer implements RequestExceptionDeserializer
{
    public function deserialize(RequestException $e): \Exception
    {
        $response = $e->getResponse();
        if ($response === null) {
            return $e;
        }

        $error = $this->getErrorFromResponseBody($response) ?? $this->getErrorResponseFromHeaders($response);
        if ($error === null) {
            return $e;
        }

        switch ($error->code) {
            case 'AuthenticationFailed':
                return new AuthenticationFailedException($error->message, 0, $e);
            case 'AuthorizationFailure':
                return new AuthorizationFailedException($error->message, 0, $e);
            case 'ContainerNotFound':
                return new ContainerNotFoundException($error->message, 0, $e);
            case 'ContainerAlreadyExists':
                return new ContainerAlreadyExistsException($error->message, 0, $e);
            case 'BlobNotFound':
                return new BlobNotFoundException($error->message, 0, $e);
            case 'InvalidBlockList':
                return new InvalidBlockListException($error->message, 0, $e);
            case 'TagsTooLarge':
                return new TagsTooLargeException($error->message, 0, $e);
            case 'CannotVerifyCopySource':
                return new CannotVerifyCopySourceException($error->message, 0, $e);
            case 'NoPendingCopyOperation':
                return new NoPendingCopyOperationException($error->message, 0, $e);
            default:
                return new BlobStorageException($error->message, 0, $e);
        }
    }

    public function getErrorResponseFromHeaders(ResponseInterface $response): ?ErrorResponse
    {
        $code = $response->getHeaderLine("x-ms-error-code");
        if ($code === "") {
            return null;
        }

        return new ErrorResponse($code, $response->getHeaderLine("x-ms-request-id"));
    }

    private function getErrorFromResponseBody(ResponseInterface $response): ?ErrorResponse
    {
        $content = $response->getBody()->getContents();
        if ($content === "") {
            return null;
        }

        return ErrorResponse::fromXml(new \SimpleXMLElement($content));
    }
}
