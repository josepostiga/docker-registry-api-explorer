<?php

namespace Josepostiga\DockerRegistry\Tests\Unit\Repositories;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Josepostiga\DockerRegistry\Tests\TestCase;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;
use Josepostiga\DockerRegistry\Repositories\DockerRegistryCatalogRepository;

class DockerRegistryCatalogRepositoryTest extends TestCase
{
    /** @test */
    public function it_creates_a_valid_instance(): void
    {
        $catalogRepository = $this->app->makeWith(DockerRegistryCatalogRepository::class, [
            'apiClient' => $this->createMock(DockerRegistryClientInterface::class),
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

        $this->mock(DockerRegistryClientInterface::class, function ($mock) use ($expectedResponse) {
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
