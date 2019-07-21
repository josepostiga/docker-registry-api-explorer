<?php

namespace Josepostiga\DockerRegistry\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Josepostiga\DockerRegistry\DockerRegistryServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            DockerRegistryServiceProvider::class,
        ];
    }

    public function setUp(): void
    {
        parent::setUp();
    }
}
