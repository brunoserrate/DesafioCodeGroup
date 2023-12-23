<?php

namespace App\Repositories;

use App\Models\Jogador;
use App\Repositories\BaseRepository;

/**
 * Class JogadorRepository
 * @package App\Repositories
 * @version December 23, 2023, 2:24 am UTC
*/

class JogadorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nome',
        'nivel',
        'posicao_time_id'
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
        return Jogador::class;
    }

    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        $query->leftJoin('posicao_time', 'posicao_time.id', '=', 'jogador.posicao_time_id');

        $columns = [
            'jogador.*',
            'posicao_time.nome as posicao_time_nome'
        ];

        return $query->get($columns);
    }
}
