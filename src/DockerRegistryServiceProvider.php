<?php

namespace Josepostiga\DockerRegistry;

use Illuminate\Support\ServiceProvider;
use Josepostiga\DockerRegistry\Services\DockerRegistryApiClient;

class DockerRegistryServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('docker-registry.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'docker-registry');

        $this->app->singleton(DockerRegistryApiClient::class, function () {
            return new DockerRegistryApiClient(config('docker-registry.url'), config('docker-registry.port'));
        });
    }
}
