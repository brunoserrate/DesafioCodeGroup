<?php

namespace Database\Factories;

use App\Models\Partida;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartidaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Partida::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->word,
        'data_partida' => $this->faker->date('Y-m-d H:i:s'),
        'qtd_jogadores_time' => $this->faker->randomDigitNotNull,
        'times_gerados' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
