<?php

namespace App\Repositories;

use App\Models\Time;
use App\Repositories\BaseRepository;

use App\Models\PartidaTime;
use App\Models\TimeJogador;

/**
 * Class TimeRepository
 * @package App\Repositories
 * @version December 24, 2023, 3:25 am UTC
*/

class TimeRepository extends BaseRepository
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
        return Time::class;
    }

    public function create($input) {

        $jogadores = $input['jogadores'];
        $time = [
            'nome' => $input['nome'],
        ];

        $model = $this->model->newInstance($time);

        $model->save();

        $dataRegistro = date('Y-m-d H:i:s');

        PartidaTime::create([
            'partida_id' => $input['partida_id'],
            'time_id' => $model->id,
            'created_at' => $dataRegistro,
            'updated_at' => $dataRegistro,
        ]);

        foreach ($jogadores as $jogador) {
            TimeJogador::create([
                'time_id' => $model->id,
                'jogador_id' => $jogador['id'],
                'created_at' => $dataRegistro,
                'updated_at' => $dataRegistro,
            ]);
        }

        return $model;
    }
}
