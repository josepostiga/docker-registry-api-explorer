<?php

namespace Josepostiga\DockerRegistry\Tests\Unit\Repositories;

use Mockery\MockInterface;
use GuzzleHttp\Psr7\Response;
use Josepostiga\DockerRegistry\Tests\TestCase;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;
use Josepostiga\DockerRegistry\Repositories\DockerRegistryManifestsRepository;

class DockerRegistryManifestsRepositoryTest extends TestCase
{
    /** @test */
    public function it_creates_a_valid_instance(): void
    {
        $manifestsRepository = $this->app->makeWith(DockerRegistryManifestsRepository::class, [
            'image' => 'php',
            'tag' => '7.2-fpm',
        ]);

        $this->assertInstanceOf(DockerRegistryManifestsRepository::class, $manifestsRepository);
        $this->assertEquals('php', $manifestsRepository->getImage());
        $this->assertEquals('7.2-fpm', $manifestsRepository->getTag());
    }

    /** @test */
    public function it_gets_details_of_an_image_tag(): void
    {
        $expectedResponse = new Response(
            200,
            [],
            json_encode([
                'schemaVersion' => 1,
                'name' => 'php',
                'tag' => '7.2-fpm',
                'architecture' => 'amd64',
                'fsLayers' => [
                    [
                        'blobSum' => 'sha256:f8389830258d9330a4cf74606a7d3a20ba64b7d2a03cf5f763b8ff36068a6f70',
                    ],
                ],
                'history' => [],
                'signatures' => [],
            ])
        );

        $this->mock(DockerRegistryClientInterface::class, function (MockInterface $mock) use ($expectedResponse) {
            $mock->shouldReceive('call')
                ->with('get', 'php/manifests/7.2-fpm')
                ->once()
                ->andReturn($expectedResponse);
        });

        /** @var DockerRegistryManifestsRepository $manifestsRepository */
        $manifestsRepository = $this->app->makeWith(DockerRegistryManifestsRepository::class, [
            'image' => 'php',
            'tag' => '7.2-fpm',
        ]);

        $manifest = $manifestsRepository->get();

        $this->assertEquals(1, $manifest->getSchema());
        $this->assertEquals('php', $manifest->getName());
        $this->assertEquals('7.2-fpm', $manifest->getTag());
        $this->assertEquals('amd64', $manifest->getArchitecture());
        $this->assertEquals(
            [
                [
                    'blobSum' => 'sha256:f8389830258d9330a4cf74606a7d3a20ba64b7d2a03cf5f763b8ff36068a6f70',
                ],
            ],
            $manifest->getLayers()
        );
        $this->assertEquals([], $manifest->getHistory());
        $this->assertEquals([], $manifest->getSignatures());
    }
}
