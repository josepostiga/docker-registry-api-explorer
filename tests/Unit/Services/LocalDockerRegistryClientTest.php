<?php

namespace Josepostiga\DockerRegistry\Tests\Unit\Services;

use Error;
use stdClass;
use GuzzleHttp\ClientInterface;
use Josepostiga\DockerRegistry\Tests\TestCase;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;

class LocalDockerRegistryClientTest extends TestCase
{
    /** @var DockerRegistryClientInterface */
    private $client;

    /** @var array */
    private $config;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->app->make(DockerRegistryClientInterface::class);
        $this->config = $this->app->config->get('docker-registry');
    }

    /** @test */
    public function it_creates_a_valid_instance(): void
    {
        $this->assertEquals($this->config['url'], $this->client->getUrl());
        $this->assertEquals($this->config['port'], $this->client->getPort());
        $this->assertEquals($this->config['version'], $this->client->getVersion());
        $this->assertInstanceOf(ClientInterface::class, $this->client->getClient());
    }

    /** @test */
    public function it_is_singleton(): void
    {
        // creates a new instance
        $otherApiClient = $this->app->make(DockerRegistryClientInterface::class);

        // asserts the two objects reference the same instance
        $this->assertSame($this->client, $otherApiClient);
    }

    /** @test */
    public function it_cant_change_url_property_after_instantiation(): void
    {
        $this->expectException(Error::class);

        $this->client->url = 'http://some-other.url';
    }

    /** @test */
    public function it_cant_change_port_property_after_instantiation(): void
    {
        $this->expectException(Error::class);

        $this->client->port = 1234;
    }

    /** @test */
    public function it_cant_change_version_property_after_instantiation(): void
    {
        $this->expectException(Error::class);

        $this->client->version = 'v1';
    }

    /** @test */
    public function it_cant_change_client_property(): void
    {
        $this->expectException(Error::class);

        $this->client->client = new stdClass();
    }
}
