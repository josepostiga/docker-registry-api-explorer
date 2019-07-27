<?php

namespace Josepostiga\DockerRegistry\Tests\Unit\Repositories;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Josepostiga\DockerRegistry\Tests\TestCase;
use Josepostiga\DockerRegistry\Contracts\DockerRegistryClientInterface;
use Josepostiga\DockerRegistry\Repositories\DockerRegistryTagsRepository;

class DockerRegistryTagsRepositoryTest extends TestCase
{
    /** @test */
    public function it_creates_a_valid_instance(): void
    {
        $tagsRepository = $this->app->makeWith(DockerRegistryTagsRepository::class, [
            'image' => 'php',
        ]);

        $this->assertInstanceOf(DockerRegistryTagsRepository::class, $tagsRepository);
        $this->assertEquals('php', $tagsRepository->getImage());
    }

    /** @test */
    public function it_gets_list_of_tags(): void
    {
        $expectedResponse = new Response(
            200,
            [],
            json_encode([
                'name' => 'php',
                'tags' => [
                    '7.2-fpm',
                ],
            ])
        );

        $this->mock(DockerRegistryClientInterface::class, function ($mock) use ($expectedResponse) {
            $mock->shouldReceive('call')
                ->with('php/tags/list')
                ->once()
                ->andReturn($expectedResponse);
        });

        $tagsRepository = $this->app->makeWith(DockerRegistryTagsRepository::class, [
            'image' => 'php',
        ]);

        $tags = $tagsRepository->list();

        $this->assertInstanceOf(Collection::class, $tags);
        $this->assertCount(1, $tags);
    }
}
