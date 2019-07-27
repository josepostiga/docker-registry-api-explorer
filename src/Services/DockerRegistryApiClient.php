<?php

namespace Josepostiga\DockerRegistry\Services;

use GuzzleHttp\Client;

class DockerRegistryApiClient
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
     * DockerRegistryApiClient constructor.
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
     * @param $name
     * @param $arguments
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function __call($name, $arguments)
    {
        return $this->getClient()->$name(...$arguments);
    }
}
