<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Jogador;

class JogadorApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_jogador()
    {
        $jogador = Jogador::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/jogadors', $jogador
        );

        $this->assertApiResponse($jogador);
    }

    /**
     * @test
     */
    public function test_read_jogador()
    {
        $jogador = Jogador::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/jogadors/'.$jogador->id
        );

        $this->assertApiResponse($jogador->toArray());
    }

    /**
     * @test
     */
    public function test_update_jogador()
    {
        $jogador = Jogador::factory()->create();
        $editedJogador = Jogador::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/jogadors/'.$jogador->id,
            $editedJogador
        );

        $this->assertApiResponse($editedJogador);
    }

    /**
     * @test
     */
    public function test_delete_jogador()
    {
        $jogador = Jogador::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/jogadors/'.$jogador->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/jogadors/'.$jogador->id
        );

        $this->response->assertStatus(404);
    }
}
