<?php

namespace Josepostiga\DockerRegistry;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;

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

        $this->app->singleton(DockerRegistryClientInterface::class, function (Application $app) {
            $config = $app->config->get('docker-registry');

            return new $config['service']($config['url'], $config['port'], $config['version']);
        });
    }
}
