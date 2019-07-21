<?php

namespace Josepostiga\DockerRegistry\Tests\Unit;

use Error;
use stdClass;
use GuzzleHttp\ClientInterface;
use Josepostiga\DockerRegistry\Tests\TestCase;
use Josepostiga\DockerRegistry\Services\DockerRegistryApiClient;

class DockerRegistryApiClientTest extends TestCase
{
    /** @test */
    public function it_creates_a_valid_instance(): void
    {
        $url = 'http://0.0.0.0';
        $port = 5000;
        $version = 'v2';

        $apiClient = $this->app->makeWith(DockerRegistryApiClient::class, [
            'url' => $url,
            'port' => $port,
            'version' => $version,
        ]);

        $this->assertEquals($url, $apiClient->getUrl());
        $this->assertEquals($port, $apiClient->getPort());
        $this->assertEquals($version, $apiClient->getVersion());
        $this->assertInstanceOf(ClientInterface::class, $apiClient->getClient());
    }

    /** @test */
    public function it_is_singleton(): void
    {
        // creates a default instance
        $apiClient = $this->app->make(DockerRegistryApiClient::class);

        // tries to create a new instance with different values
        $url = 'http://0.0.0.1';
        $port = 5001;
        $version = 'v2';

        $otherApiClient = $this->app->makeWith(DockerRegistryApiClient::class, [
            'url' => $url,
            'port' => $port,
            'version' => $version,
        ]);

        $this->assertEquals($apiClient->getUrl(), $otherApiClient->getUrl());
        $this->assertEquals($apiClient->getPort(), $otherApiClient->getPort());
        $this->assertEquals($apiClient->getVersion(), $otherApiClient->getVersion());
    }

    /** @test */
    public function it_cant_change_url_property_after_instantiation(): void
    {
        $this->expectException(Error::class);

        $apiClient = $this->app->make(DockerRegistryApiClient::class);

        $apiClient->url = 'http://some-other.url';
    }

    /** @test */
    public function it_cant_change_port_property_after_instantiation(): void
    {
        $this->expectException(Error::class);

        $apiClient = $this->app->make(DockerRegistryApiClient::class);

        $apiClient->port = 1234;
    }

    /** @test */
    public function it_cant_change_version_property_after_instantiation(): void
    {
        $this->expectException(Error::class);

        $apiClient = $this->app->make(DockerRegistryApiClient::class);

        $apiClient->version = 'v1';
    }

    /** @test */
    public function it_cant_change_client_property(): void
    {
        $this->expectException(Error::class);

        $apiClient = $this->app->make(DockerRegistryApiClient::class);

        $apiClient->client = new stdClass();
    }
}
