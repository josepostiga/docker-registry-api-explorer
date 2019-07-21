<?php

namespace Josepostiga\DockerRegistry\Tests;

use Josepostiga\DockerRegistry\DockerRegistryServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

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
