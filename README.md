# Simple Docker Registry API Explorer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/josepostiga/docker-registry-api-explorer.svg?style=flat-square)](https://packagist.org/packages/josepostiga/docker-registry-api-explorer)
[![Build Status](https://img.shields.io/travis/josepostiga/docker-registry-api-explorer/master.svg?style=flat-square)](https://travis-ci.org/josepostiga/docker-registry-api-explorer)
[![Quality Score](https://img.shields.io/scrutinizer/g/josepostiga/docker-registry-api-explorer.svg?style=flat-square)](https://scrutinizer-ci.com/g/josepostiga/docker-registry-api-explorer)
[![StyleCI](https://github.styleci.io/repos/198105219/shield)](https://github.styleci.io/repos/198105219)
[![Total Downloads](https://img.shields.io/packagist/dt/josepostiga/docker-registry-api-explorer.svg?style=flat-square)](https://packagist.org/packages/josepostiga/docker-registry-api-explorer)

## Installation

You can install the package via composer:

```bash
composer require josepostiga/docker-registry-api-explorer
```

**Note**

This package needs an accessible official Docker Registry container to be up and running. Please refer to the [Docker documentation](https://docs.docker.com/registry/) to know how to boot a private registry.

## Usage

Before using this package, you need to publish the configuration:

```bash
php artisan vendor:publish --tag=config
```

A new `docker-registry.php` config file will be published in the `config` folder. Inside of it, you'll find a few configuration items you need to modify according to your reality, specifically the "url", which is the publicly accessible url of the Docker registry you'll connect to.

### Catalogs

The Docker Registry references "Catalogs" as a directory of available images repositories. Here's an example to get all available repositories:

```php
class RepositoriesController
{
    public function index(DockerRegistryCatalogRepository $repository)
    {
        return $repository->list();
    }
}
```

### Tags

Tags are associated with an image repository. To access this list, you need to pass the image you want to access the related tags. Here's an example to get all tags associated with an image repository:

```php
class TagsController
{
    public function index(string $image)
    {
        // the $image variable is a route placeholder, automatically injected by Laravel as a controller method param.
        $repository = App::makeWith(DockerRegistryTagsRepository::class, [
            'image' => $image
        ]);

        return $repository->list();
    }
}
```

### Manifests

A Manifest is a detailed document about what changes and information an image tag is referring to. Here's an example to get the manifest of a tag associated with an image repository:

```php
class ManifestController
{
    public function index(string $image, string $tag)
    {
        // the $image and $tag variables are route placeholders, automatically injected by Laravel as controller method params.
        $manifest = App::makeWith(DockerRegistryManifestRepository::class, [
            'image' => $image,
            'tag' => $tag,
        ]);

        return $manifest->get();
    }
}
```

#### Note

Right now, this package only supports simple operations available on the [official Docker Registry HTTP API](https://docs.docker.com/registry/spec/api/).

Other types of registries are not supported, yet. Feel free to help out on that.

### Testing

``` bash
vendor/bin/phpunit
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please [email me](mailto:josepostiga@icloud.com) or [Telegram](https://t.me/josepostiga) instead of using the issue tracker.

## Credits

- [José Postiga](https://github.com/josepostiga)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
