<?php

namespace App\Repositories;

use App\Models\Partida;
use App\Repositories\BaseRepository;

use App\Repositories\TimeRepository;

/**
 * Class PartidaRepository
 * @package App\Repositories
 * @version December 24, 2023, 3:22 am UTC
*/

class PartidaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nome',
        'data_partida',
        'qtd_jogadores_time',
        'times_gerados'
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
        return Partida::class;
    }

    public function create($input) {

        $times = $input['times'];
        $partida = [
            'nome' => $input['nome'],
            'data_partida' => $input['data_partida'],
            'qtd_jogadores_time' => $input['qtd_jogadores_time'],
            'times_gerados' => count($times),
        ];

        $partida['data_partida'] = date('Y-m-d H:i:s', strtotime($partida['data_partida']));

        $model = $this->model->newInstance($partida);

        $model->save();

        foreach ($times as $time) {
            $time['partida_id'] = $model->id;

            $timeRepository = new TimeRepository($this->app);

            $timeRepository->create($time);
        }

        return $model;

    }

    public function gerarTime($input) {

        $jogadores = $input['jogadores'];
        $qtd_jogadores_time = $input['qtd_jogadores_time'];

        $goleiros = [];
        $outros = [];

        foreach ($jogadores as $jogador) {
            if($jogador['posicao_time_id'] == 1) { // Goleiro
                $goleiros[] = $jogador;

                continue;
            }

            $outros[] = $jogador;
        }

        $times = [];

        $qtd_times = count($jogadores) / $qtd_jogadores_time;

        for ($i = 0; $i < $qtd_times; $i++) {
            $jogadores_time = $this->organizarJogadores($goleiros, $outros, $qtd_jogadores_time);

            $times[$i] = [
                'nome' => 'Time ' . ($i + 1),
                'jogadores' => $jogadores_time,
                'qtd_jogadores' => count($jogadores_time)
            ];
        }

        return $times;
    }

    private function organizarJogadores(&$goleiros, &$outros, $qtd_jogadores_time) {
        $jogadores = [];

        $jogadores[] = array_pop($goleiros);

        for ($i = 1; $i < $qtd_jogadores_time; $i++) {
            $jogadores[] = array_pop($outros);
        }

        return $jogadores;
    }

}
