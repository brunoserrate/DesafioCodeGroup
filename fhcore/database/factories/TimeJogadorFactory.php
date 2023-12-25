<?php

namespace Database\Factories;

use App\Models\TimeJogador;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeJogadorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimeJogador::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'jogador_id' => $this->faker->randomDigitNotNull,
        'time_id' => $this->faker->randomDigitNotNull
        ];
    }
}
