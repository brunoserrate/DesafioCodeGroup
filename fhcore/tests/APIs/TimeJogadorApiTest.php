<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\TimeJogador;

class TimeJogadorApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_time_jogador()
    {
        $timeJogador = TimeJogador::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/time_jogadors', $timeJogador
        );

        $this->assertApiResponse($timeJogador);
    }

    /**
     * @test
     */
    public function test_read_time_jogador()
    {
        $timeJogador = TimeJogador::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/time_jogadors/'.$timeJogador->id
        );

        $this->assertApiResponse($timeJogador->toArray());
    }

    /**
     * @test
     */
    public function test_update_time_jogador()
    {
        $timeJogador = TimeJogador::factory()->create();
        $editedTimeJogador = TimeJogador::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/time_jogadors/'.$timeJogador->id,
            $editedTimeJogador
        );

        $this->assertApiResponse($editedTimeJogador);
    }

    /**
     * @test
     */
    public function test_delete_time_jogador()
    {
        $timeJogador = TimeJogador::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/time_jogadors/'.$timeJogador->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/time_jogadors/'.$timeJogador->id
        );

        $this->response->assertStatus(404);
    }
}
