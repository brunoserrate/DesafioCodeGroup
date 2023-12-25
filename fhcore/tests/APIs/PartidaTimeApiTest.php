<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PartidaTime;

class PartidaTimeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_partida_time()
    {
        $partidaTime = PartidaTime::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/partida_times', $partidaTime
        );

        $this->assertApiResponse($partidaTime);
    }

    /**
     * @test
     */
    public function test_read_partida_time()
    {
        $partidaTime = PartidaTime::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/partida_times/'.$partidaTime->id
        );

        $this->assertApiResponse($partidaTime->toArray());
    }

    /**
     * @test
     */
    public function test_update_partida_time()
    {
        $partidaTime = PartidaTime::factory()->create();
        $editedPartidaTime = PartidaTime::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/partida_times/'.$partidaTime->id,
            $editedPartidaTime
        );

        $this->assertApiResponse($editedPartidaTime);
    }

    /**
     * @test
     */
    public function test_delete_partida_time()
    {
        $partidaTime = PartidaTime::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/partida_times/'.$partidaTime->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/partida_times/'.$partidaTime->id
        );

        $this->response->assertStatus(404);
    }
}
