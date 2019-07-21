<?php

namespace Josepostiga\DockerRegistry\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Josepostiga\DockerRegistry\Tests\TestCase;
use Josepostiga\DockerRegistry\Services\DockerRegistryApiClient;
use Josepostiga\DockerRegistry\Repositories\DockerRegistryCatalogRepository;

class DockerRegistryCatalogRepositoryTest extends TestCase
{
    /** @test */
    public function it_creates_a_valid_instance(): void
    {
        $catalogRepository = $this->app->makeWith(DockerRegistryCatalogRepository::class, [
            'apiClient' => $this->createMock(DockerRegistryApiClient::class),
        ]);

        $this->assertInstanceOf(DockerRegistryCatalogRepository::class, $catalogRepository);
    }

    /** @test */
    public function it_gets_list_of_repositories(): void
    {
        $expectedResponse = new Response(
            200,
            [],
            json_encode([
                'repositories' => [
                    'repo-1',
                    'repo-2',
                    'repo-3',
                ],
            ])
        );

        $this->mock(DockerRegistryApiClient::class, function ($mock) use ($expectedResponse) {
            $mock->shouldReceive('get')
                ->once()
                ->andReturn($expectedResponse);
        });

        $catalogRepository = $this->app->make(DockerRegistryCatalogRepository::class);

        $repositories = $catalogRepository->getAll();

        $this->assertInstanceOf(Collection::class, $repositories);
        $this->assertCount(3, $repositories);
    }
}
