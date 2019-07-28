<?php

namespace Josepostiga\DockerRegistry\Objects;

final class Manifest
{
    /**
     * Schema version.
     *
     * @var int
     */
    private $schema;

    /**
     * Image name.
     *
     * @var string
     */
    private $name;

    /**
     * Tag name.
     *
     * @var string
     */
    private $tag;

    /**
     * Architecture used.
     *
     * @var string
     */
    private $architecture;

    /**
     * Layers that make the tagged image.
     *
     * @var array
     */
    private $layers;

    /**
     * List of changes made.
     *
     * @var array
     */
    private $history;

    /**
     * List of signatures.
     *
     * @var array
     */
    private $signatures;

    /**
     * Manifest constructor.
     *
     * @param int $schema
     * @param string $name
     * @param string $tag
     * @param string $architecture
     * @param array $layers
     * @param array $history
     * @param array $signatures
     */
    public function __construct(int $schema, string $name, string $tag, string $architecture, array $layers, array $history, array $signatures)
    {
        $this->schema = $schema;
        $this->name = $name;
        $this->tag = $tag;
        $this->architecture = $architecture;
        $this->layers = $layers;
        $this->history = $history;
        $this->signatures = $signatures;
    }

    /**
     * Gets the schema.
     *
     * @return int
     */
    public function getSchema(): int
    {
        return $this->schema;
    }

    /**
     * Gets the image name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the tag.
     *
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * Gets the architecture.
     *
     * @return string
     */
    public function getArchitecture(): string
    {
        return $this->architecture;
    }

    /**
     * Gets the layers.
     *
     * @return array
     */
    public function getLayers(): array
    {
        return $this->layers;
    }

    /**
     * Gets the history of changes.
     *
     * @return array
     */
    public function getHistory(): array
    {
        return $this->history;
    }

    /**
     * Gets the signatures.
     *
     * @return array
     */
    public function getSignatures(): array
    {
        return $this->signatures;
    }
}
