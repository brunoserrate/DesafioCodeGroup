<?php

namespace App\Repositories;

use App\Models\PosicaoTime;
use App\Repositories\BaseRepository;

/**
 * Class PosicaoTimeRepository
 * @package App\Repositories
 * @version December 23, 2023, 3:37 am UTC
*/

class PosicaoTimeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nome'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PosicaoTime::class;
    }
}
