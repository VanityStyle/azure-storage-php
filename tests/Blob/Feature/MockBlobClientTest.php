<?php

declare(strict_types=1);

namespace AzureOss\Storage\Tests\Blob\Feature;

use AzureOss\Storage\Blob\BlobClient;
use AzureOss\Storage\Blob\BlobServiceClient;
use AzureOss\Storage\Blob\Models\UploadBlobOptions;
use AzureOss\Storage\Tests\Utils\FileFactory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Server\Server;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

class MockBlobClientTest extends TestCase
{
    private BlobClient $mockBlobClient;

    protected function setUp(): void
    {
        Server::start();

        /** @phpstan-ignore-next-line */
        $uri = new Uri(Server::$url . '/devstoreaccount1');
        $mockServiceClient = new BlobServiceClient($uri);
        $mockContainerClient = $mockServiceClient->getContainerClient('test');
        $this->mockBlobClient = $mockContainerClient->getBlobClient('test');
    }

    protected function tearDown(): void
    {
        Server::stop();
    }

    public function upload_single_sends_correct_amount_of_requests(): void
    {
        $this->expectNotToPerformAssertions();
        Server::enqueue([
            new Response(200), // only one request
            new Response(501), // fail if more requests
        ]);
        FileFactory::withStream(1000, function (StreamInterface $file) {
            $this->mockBlobClient->upload($file, new UploadBlobOptions("text/plain", 2000));
        });
    }

    public function upload_parallel_blocks_sends_correct_amount_of_requests(): void
    {
        $this->expectNotToPerformAssertions();
        // should not throw because of the 501
        Server::enqueue(array_merge(array_fill(0, 11, new Response(200)), [
            // 10 chunks + 1 commit request
            new Response(501),
        ]));
        FileFactory::withStream(50_000_000, function (StreamInterface $file) {
            $this->mockBlobClient->upload($file, new UploadBlobOptions("text/plain", 0, 5_000_000));
        });
    }

    public function upload_parallel_blocks_sends_correct_amount_of_requests_for_small_files(): void
    {
        $this->expectNotToPerformAssertions();
        // should not throw because of the 501
        Server::enqueue(array_merge(array_fill(0, 2, new Response(200)), [
            // 1 chunks + 1 commit request
            new Response(501),
        ]));
        FileFactory::withStream(50_000, function (StreamInterface $file) {
            $this->mockBlobClient->upload($file, new UploadBlobOptions("text/plain", 0, 8_000_000));
        });
    }

    public function upload_sequential_blocks_sends_correct_amount_of_requests(): void
    {
        $this->expectNotToPerformAssertions();
        // should not throw because of the 501
        Server::enqueue(array_merge(array_fill(0, 11, new Response(200)), [
            // 10 chunks + 1 commit request
            new Response(501),
        ]));
        FileFactory::withStream(50_000_000, function (StreamInterface $file) {
            $stream = new class ($file) implements StreamInterface {
                use StreamDecoratorTrait;

                public function getSize(): ?int
                {
                    return null;
                }
            };

            $this->mockBlobClient->upload($stream, new UploadBlobOptions("text/plain", 0, 5_000_000));
        });
    }

    public function upload_parallel_blocks_sends_correct_amount_of_requests_with_a_network_request(): void
    {
        $this->expectNotToPerformAssertions();
        // should not throw because of the 501
        Server::enqueue(array_merge([new Response(200, [], str_repeat('X', 50_000_000))], array_fill(0, 20, new Response(200)), [
            // with network streams some chunks in the beginning are smaller. It should be less than 20 requests still.
            new Response(501),
        ]));
        /** @phpstan-ignore-next-line */
        $stream = fopen(Server::$url, 'r');
        if ($stream === false) {
            self::fail();
        }
        $this->mockBlobClient->upload($stream, new UploadBlobOptions("text/plain", 0, 5_000_000));
    }
}
