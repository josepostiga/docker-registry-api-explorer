<?php

namespace Josepostiga\DockerRegistry\Repositories;

use Josepostiga\DockerRegistry\Objects\Manifest;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;

final class DockerRegistryManifestsRepository
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
     * Tag name.
     *
     * @var string
     */
    private $tag;

    /**
     * DockerRegistryManifestsRepository constructor.
     *
     * @param DockerRegistryClientInterface $client
     * @param string $image
     * @param string $tag
     */
    public function __construct(DockerRegistryClientInterface $client, string $image, string $tag)
    {
        $this->client = $client;
        $this->image = $image;
        $this->tag = $tag;
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
     * Gets tag name.
     *
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * Gets manifest details of given image related tag.
     *
     * @return Manifest
     */
    public function get(): Manifest
    {
        $request = $this->client->call($this->getImage().'/manifests/'.$this->getTag());

        $response = json_decode($request->getBody(), true);

        return new Manifest(
            $response['schemaVersion'],
            $response['name'],
            $response['tag'],
            $response['architecture'],
            $response['fsLayers'],
            $response['history'],
            $response['signatures']
        );
    }
}
