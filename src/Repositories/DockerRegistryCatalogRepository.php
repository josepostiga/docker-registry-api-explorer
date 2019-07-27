<?php

namespace Josepostiga\DockerRegistry\Repositories;

use Illuminate\Support\Collection;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;

final class DockerRegistryCatalogRepository
{
    /**
     * @var DockerRegistryClientInterface
     */
    private $client;

    public function __construct(DockerRegistryClientInterface $client)
    {
        $this->client = $client;
    }

    public function getAll(): Collection
    {
        $request = $this->client->call('_catalog');

        $response = json_decode($request->getBody(), true);

        return new Collection($response['repositories']);
    }
}
