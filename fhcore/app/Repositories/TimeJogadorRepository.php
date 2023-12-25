<?php

namespace App\Repositories;

use App\Models\TimeJogador;
use App\Repositories\BaseRepository;

/**
 * Class TimeJogadorRepository
 * @package App\Repositories
 * @version December 25, 2023, 12:00 am UTC
*/

class TimeJogadorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'jogador_id',
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
        return TimeJogador::class;
    }
}
