<?php

namespace Josepostiga\DockerRegistry\Services;

use GuzzleHttp\Client;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;

final class LocalDockerRegistryClient implements DockerRegistryClientInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $port;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $version;

    /**
     * LocalDockerRegistryClient constructor.
     *
     * @param string $url
     * @param int $port
     * @param string $version
     */
    public function __construct(string $url, int $port, string $version)
    {
        $this->url = $url;
        $this->port = $port;
        $this->version = $version;

        $this->client = new Client([
            'base_uri' => "{$this->getUrl()}:{$this->getPort()}/{$this->getVersion()}",
        ]);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Proxies method calls to the Http client instance.
     *
     * @param string $verb
     * @param string $resource
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    public function call(string $verb, string $resource, ...$arguments)
    {
        return $this->getClient()->$verb($resource, ...$arguments);
    }
}
