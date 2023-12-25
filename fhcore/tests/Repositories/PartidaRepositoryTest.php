<?php namespace Tests\Repositories;

use App\Models\Partida;
use App\Repositories\PartidaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PartidaRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PartidaRepository
     */
    protected $partidaRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->partidaRepo = \App::make(PartidaRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_partida()
    {
        $partida = Partida::factory()->make()->toArray();

        $createdPartida = $this->partidaRepo->create($partida);

        $createdPartida = $createdPartida->toArray();
        $this->assertArrayHasKey('id', $createdPartida);
        $this->assertNotNull($createdPartida['id'], 'Created Partida must have id specified');
        $this->assertNotNull(Partida::find($createdPartida['id']), 'Partida with given id must be in DB');
        $this->assertModelData($partida, $createdPartida);
    }

    /**
     * @test read
     */
    public function test_read_partida()
    {
        $partida = Partida::factory()->create();

        $dbPartida = $this->partidaRepo->find($partida->id);

        $dbPartida = $dbPartida->toArray();
        $this->assertModelData($partida->toArray(), $dbPartida);
    }

    /**
     * @test update
     */
    public function test_update_partida()
    {
        $partida = Partida::factory()->create();
        $fakePartida = Partida::factory()->make()->toArray();

        $updatedPartida = $this->partidaRepo->update($fakePartida, $partida->id);

        $this->assertModelData($fakePartida, $updatedPartida->toArray());
        $dbPartida = $this->partidaRepo->find($partida->id);
        $this->assertModelData($fakePartida, $dbPartida->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_partida()
    {
        $partida = Partida::factory()->create();

        $resp = $this->partidaRepo->delete($partida->id);

        $this->assertTrue($resp);
        $this->assertNull(Partida::find($partida->id), 'Partida should not exist in DB');
    }
}
