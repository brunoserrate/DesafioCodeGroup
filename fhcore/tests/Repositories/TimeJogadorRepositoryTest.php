<?php namespace Tests\Repositories;

use App\Models\TimeJogador;
use App\Repositories\TimeJogadorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TimeJogadorRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TimeJogadorRepository
     */
    protected $timeJogadorRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->timeJogadorRepo = \App::make(TimeJogadorRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_time_jogador()
    {
        $timeJogador = TimeJogador::factory()->make()->toArray();

        $createdTimeJogador = $this->timeJogadorRepo->create($timeJogador);

        $createdTimeJogador = $createdTimeJogador->toArray();
        $this->assertArrayHasKey('id', $createdTimeJogador);
        $this->assertNotNull($createdTimeJogador['id'], 'Created TimeJogador must have id specified');
        $this->assertNotNull(TimeJogador::find($createdTimeJogador['id']), 'TimeJogador with given id must be in DB');
        $this->assertModelData($timeJogador, $createdTimeJogador);
    }

    /**
     * @test read
     */
    public function test_read_time_jogador()
    {
        $timeJogador = TimeJogador::factory()->create();

        $dbTimeJogador = $this->timeJogadorRepo->find($timeJogador->id);

        $dbTimeJogador = $dbTimeJogador->toArray();
        $this->assertModelData($timeJogador->toArray(), $dbTimeJogador);
    }

    /**
     * @test update
     */
    public function test_update_time_jogador()
    {
        $timeJogador = TimeJogador::factory()->create();
        $fakeTimeJogador = TimeJogador::factory()->make()->toArray();

        $updatedTimeJogador = $this->timeJogadorRepo->update($fakeTimeJogador, $timeJogador->id);

        $this->assertModelData($fakeTimeJogador, $updatedTimeJogador->toArray());
        $dbTimeJogador = $this->timeJogadorRepo->find($timeJogador->id);
        $this->assertModelData($fakeTimeJogador, $dbTimeJogador->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_time_jogador()
    {
        $timeJogador = TimeJogador::factory()->create();

        $resp = $this->timeJogadorRepo->delete($timeJogador->id);

        $this->assertTrue($resp);
        $this->assertNull(TimeJogador::find($timeJogador->id), 'TimeJogador should not exist in DB');
    }
}
