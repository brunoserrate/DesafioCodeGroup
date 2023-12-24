<?php namespace Tests\Repositories;

use App\Models\Jogador;
use App\Repositories\JogadorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class JogadorRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var JogadorRepository
     */
    protected $jogadorRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->jogadorRepo = \App::make(JogadorRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_jogador()
    {
        $jogador = Jogador::factory()->make()->toArray();

        $createdJogador = $this->jogadorRepo->create($jogador);

        $createdJogador = $createdJogador->toArray();
        $this->assertArrayHasKey('id', $createdJogador);
        $this->assertNotNull($createdJogador['id'], 'Created Jogador must have id specified');
        $this->assertNotNull(Jogador::find($createdJogador['id']), 'Jogador with given id must be in DB');
        $this->assertModelData($jogador, $createdJogador);
    }

    /**
     * @test read
     */
    public function test_read_jogador()
    {
        $jogador = Jogador::factory()->create();

        $dbJogador = $this->jogadorRepo->find($jogador->id);

        $dbJogador = $dbJogador->toArray();
        $this->assertModelData($jogador->toArray(), $dbJogador);
    }

    /**
     * @test update
     */
    public function test_update_jogador()
    {
        $jogador = Jogador::factory()->create();
        $fakeJogador = Jogador::factory()->make()->toArray();

        $updatedJogador = $this->jogadorRepo->update($fakeJogador, $jogador->id);

        $this->assertModelData($fakeJogador, $updatedJogador->toArray());
        $dbJogador = $this->jogadorRepo->find($jogador->id);
        $this->assertModelData($fakeJogador, $dbJogador->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_jogador()
    {
        $jogador = Jogador::factory()->create();

        $resp = $this->jogadorRepo->delete($jogador->id);

        $this->assertTrue($resp);
        $this->assertNull(Jogador::find($jogador->id), 'Jogador should not exist in DB');
    }
}
