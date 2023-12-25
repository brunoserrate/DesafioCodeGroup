<?php

namespace App\Repositories;

use App\Models\PartidaTime;
use App\Repositories\BaseRepository;

/**
 * Class PartidaTimeRepository
 * @package App\Repositories
 * @version December 25, 2023, 12:10 am UTC
*/

class PartidaTimeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'partida_id',
        'time_id'
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
        return PartidaTime::class;
    }
}
