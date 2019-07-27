<?php

namespace Josepostiga\DockerRegistry\Tests\Unit\Services;

use Error;
use stdClass;
use GuzzleHttp\ClientInterface;
use Josepostiga\DockerRegistry\Tests\TestCase;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;

class LocalDockerRegistryClientTest extends TestCase
{
    /** @test */
    public function it_creates_a_valid_instance(): void
    {
        $apiClient = $this->app->make(DockerRegistryClientInterface::class);

        $this->assertEquals($this->app->config->get('docker-registry.url'), $apiClient->getUrl());
        $this->assertEquals($this->app->config->get('docker-registry.port'), $apiClient->getPort());
        $this->assertEquals($this->app->config->get('docker-registry.version'), $apiClient->getVersion());
        $this->assertInstanceOf(ClientInterface::class, $apiClient->getClient());
    }

    /** @test */
    public function it_is_singleton(): void
    {
        // creates a default instance
        $apiClient = $this->app->make(DockerRegistryClientInterface::class);

        // creates a new instance
        $otherApiClient = $this->app->make(DockerRegistryClientInterface::class);

        // asserts the two objects reference the same instance
        $this->assertSame($apiClient, $otherApiClient);
    }

    /** @test */
    public function it_cant_change_url_property_after_instantiation(): void
    {
        $this->expectException(Error::class);

        $apiClient = $this->app->make(DockerRegistryClientInterface::class);

        $apiClient->url = 'http://some-other.url';
    }

    /** @test */
    public function it_cant_change_port_property_after_instantiation(): void
    {
        $this->expectException(Error::class);

        $apiClient = $this->app->make(DockerRegistryClientInterface::class);

        $apiClient->port = 1234;
    }

    /** @test */
    public function it_cant_change_version_property_after_instantiation(): void
    {
        $this->expectException(Error::class);

        $apiClient = $this->app->make(DockerRegistryClientInterface::class);

        $apiClient->version = 'v1';
    }

    /** @test */
    public function it_cant_change_client_property(): void
    {
        $this->expectException(Error::class);

        $apiClient = $this->app->make(DockerRegistryClientInterface::class);

        $apiClient->client = new stdClass();
    }
}
