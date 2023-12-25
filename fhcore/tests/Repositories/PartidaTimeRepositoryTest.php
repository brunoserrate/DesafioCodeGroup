<?php namespace Tests\Repositories;

use App\Models\PartidaTime;
use App\Repositories\PartidaTimeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PartidaTimeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PartidaTimeRepository
     */
    protected $partidaTimeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->partidaTimeRepo = \App::make(PartidaTimeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_partida_time()
    {
        $partidaTime = PartidaTime::factory()->make()->toArray();

        $createdPartidaTime = $this->partidaTimeRepo->create($partidaTime);

        $createdPartidaTime = $createdPartidaTime->toArray();
        $this->assertArrayHasKey('id', $createdPartidaTime);
        $this->assertNotNull($createdPartidaTime['id'], 'Created PartidaTime must have id specified');
        $this->assertNotNull(PartidaTime::find($createdPartidaTime['id']), 'PartidaTime with given id must be in DB');
        $this->assertModelData($partidaTime, $createdPartidaTime);
    }

    /**
     * @test read
     */
    public function test_read_partida_time()
    {
        $partidaTime = PartidaTime::factory()->create();

        $dbPartidaTime = $this->partidaTimeRepo->find($partidaTime->id);

        $dbPartidaTime = $dbPartidaTime->toArray();
        $this->assertModelData($partidaTime->toArray(), $dbPartidaTime);
    }

    /**
     * @test update
     */
    public function test_update_partida_time()
    {
        $partidaTime = PartidaTime::factory()->create();
        $fakePartidaTime = PartidaTime::factory()->make()->toArray();

        $updatedPartidaTime = $this->partidaTimeRepo->update($fakePartidaTime, $partidaTime->id);

        $this->assertModelData($fakePartidaTime, $updatedPartidaTime->toArray());
        $dbPartidaTime = $this->partidaTimeRepo->find($partidaTime->id);
        $this->assertModelData($fakePartidaTime, $dbPartidaTime->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_partida_time()
    {
        $partidaTime = PartidaTime::factory()->create();

        $resp = $this->partidaTimeRepo->delete($partidaTime->id);

        $this->assertTrue($resp);
        $this->assertNull(PartidaTime::find($partidaTime->id), 'PartidaTime should not exist in DB');
    }
}
