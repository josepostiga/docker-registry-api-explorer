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
     * Gets image name.
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * List all available tags associated to the image.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        $request = $this->client->call('get', $this->getImage().'/tags/list');

        $response = json_decode($request->getBody(), true);

        return new Collection($response['tags']);
    }
}
