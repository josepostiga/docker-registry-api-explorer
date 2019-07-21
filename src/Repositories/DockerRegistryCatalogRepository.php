<?php

namespace Josepostiga\DockerRegistry\Repositories;

use Illuminate\Support\Collection;
use Josepostiga\DockerRegistry\Services\DockerRegistryApiClient;

class DockerRegistryCatalogRepository
{
    /**
     * @var DockerRegistryApiClient
     */
    private $apiClient;

    public function __construct(DockerRegistryApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function getAll(): Collection
    {
        $request = $this->apiClient->get('_catalog');

        $response = json_decode($request->getBody(), true);

        return new Collection($response['repositories']);
    }
}
