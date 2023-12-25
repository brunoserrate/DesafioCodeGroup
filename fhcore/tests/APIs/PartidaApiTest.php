<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Partida;

class PartidaApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_partida()
    {
        $partida = Partida::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/partidas', $partida
        );

        $this->assertApiResponse($partida);
    }

    /**
     * @test
     */
    public function test_read_partida()
    {
        $partida = Partida::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/partidas/'.$partida->id
        );

        $this->assertApiResponse($partida->toArray());
    }

    /**
     * @test
     */
    public function test_update_partida()
    {
        $partida = Partida::factory()->create();
        $editedPartida = Partida::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/partidas/'.$partida->id,
            $editedPartida
        );

        $this->assertApiResponse($editedPartida);
    }

    /**
     * @test
     */
    public function test_delete_partida()
    {
        $partida = Partida::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/partidas/'.$partida->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/partidas/'.$partida->id
        );

        $this->response->assertStatus(404);
    }
}
