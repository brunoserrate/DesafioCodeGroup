<?php namespace Tests\Repositories;

use App\Models\PosicaoTime;
use App\Repositories\PosicaoTimeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PosicaoTimeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PosicaoTimeRepository
     */
    protected $posicaoTimeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->posicaoTimeRepo = \App::make(PosicaoTimeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_posicao_time()
    {
        $posicaoTime = PosicaoTime::factory()->make()->toArray();

        $createdPosicaoTime = $this->posicaoTimeRepo->create($posicaoTime);

        $createdPosicaoTime = $createdPosicaoTime->toArray();
        $this->assertArrayHasKey('id', $createdPosicaoTime);
        $this->assertNotNull($createdPosicaoTime['id'], 'Created PosicaoTime must have id specified');
        $this->assertNotNull(PosicaoTime::find($createdPosicaoTime['id']), 'PosicaoTime with given id must be in DB');
        $this->assertModelData($posicaoTime, $createdPosicaoTime);
    }

    /**
     * @test read
     */
    public function test_read_posicao_time()
    {
        $posicaoTime = PosicaoTime::factory()->create();

        $dbPosicaoTime = $this->posicaoTimeRepo->find($posicaoTime->id);

        $dbPosicaoTime = $dbPosicaoTime->toArray();
        $this->assertModelData($posicaoTime->toArray(), $dbPosicaoTime);
    }

    /**
     * @test update
     */
    public function test_update_posicao_time()
    {
        $posicaoTime = PosicaoTime::factory()->create();
        $fakePosicaoTime = PosicaoTime::factory()->make()->toArray();

        $updatedPosicaoTime = $this->posicaoTimeRepo->update($fakePosicaoTime, $posicaoTime->id);

        $this->assertModelData($fakePosicaoTime, $updatedPosicaoTime->toArray());
        $dbPosicaoTime = $this->posicaoTimeRepo->find($posicaoTime->id);
        $this->assertModelData($fakePosicaoTime, $dbPosicaoTime->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_posicao_time()
    {
        $posicaoTime = PosicaoTime::factory()->create();

        $resp = $this->posicaoTimeRepo->delete($posicaoTime->id);

        $this->assertTrue($resp);
        $this->assertNull(PosicaoTime::find($posicaoTime->id), 'PosicaoTime should not exist in DB');
    }
}
