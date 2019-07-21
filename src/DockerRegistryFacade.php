<?php

namespace Josepostiga\DockerRegistry;

use Illuminate\Support\Facades\Facade;

class DockerRegistryFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'DockerRegistryApiClient';
    }
}
