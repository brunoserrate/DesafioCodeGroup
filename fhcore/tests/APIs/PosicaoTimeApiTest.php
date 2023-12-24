<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PosicaoTime;

class PosicaoTimeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_posicao_time()
    {
        $posicaoTime = PosicaoTime::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/posicao_times', $posicaoTime
        );

        $this->assertApiResponse($posicaoTime);
    }

    /**
     * @test
     */
    public function test_read_posicao_time()
    {
        $posicaoTime = PosicaoTime::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/posicao_times/'.$posicaoTime->id
        );

        $this->assertApiResponse($posicaoTime->toArray());
    }

    /**
     * @test
     */
    public function test_update_posicao_time()
    {
        $posicaoTime = PosicaoTime::factory()->create();
        $editedPosicaoTime = PosicaoTime::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/posicao_times/'.$posicaoTime->id,
            $editedPosicaoTime
        );

        $this->assertApiResponse($editedPosicaoTime);
    }

    /**
     * @test
     */
    public function test_delete_posicao_time()
    {
        $posicaoTime = PosicaoTime::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/posicao_times/'.$posicaoTime->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/posicao_times/'.$posicaoTime->id
        );

        $this->response->assertStatus(404);
    }
}
