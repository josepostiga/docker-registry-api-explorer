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

    /**
     * DockerRegistryCatalogRepository constructor.
     *
     * @param DockerRegistryClientInterface $client
     */
    public function __construct(DockerRegistryClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * List all available repositories.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        $request = $this->client->call('get', '_catalog');

        $response = json_decode($request->getBody(), true);

        return new Collection($response['repositories']);
    }
}
