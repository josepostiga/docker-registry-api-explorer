<?php

namespace Josepostiga\DockerRegistry\Repositories;

use Illuminate\Support\Collection;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;

final class DockerRegistryTagsRepository
{
    /**
     * @var DockerRegistryClientInterface
     */
    private $client;

    /**
     * Image name.
     *
     * @var string
     */
    private $image;

    /**
     * DockerRegistryCatalogRepository constructor.
     *
     * @param DockerRegistryClientInterface $client
     * @param string $image
     */
    public function __construct(DockerRegistryClientInterface $client, string $image)
    {
        $this->client = $client;
        $this->image = $image;
    }

    /**
     * Gets related image name.
     *
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * List all available repositories.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        $request = $this->client->call("{$this->image}/tags/list");

        $response = json_decode($request->getBody(), true);

        return new Collection($response['tags']);
    }
}