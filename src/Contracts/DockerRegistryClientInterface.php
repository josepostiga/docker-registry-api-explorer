<?php

namespace Josepostiga\DockerRegistry\Contracts;

use GuzzleHttp\Client;

interface DockerRegistryClientInterface
{
    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @return int
     */
    public function getPort(): int;

    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @return Client
     */
    public function getClient(): Client;

    /**
     * Proxies method calls to the Http client instance.
     *
     * @param string $verb
     * @param string $resource
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    public function call(string $verb, string $resource, ...$arguments);
}
