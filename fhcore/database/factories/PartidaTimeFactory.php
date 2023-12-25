<?php

namespace Database\Factories;

use App\Models\PartidaTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartidaTimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PartidaTime::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'partida_id' => $this->faker->randomDigitNotNull,
        'time_id' => $this->faker->randomDigitNotNull
        ];
    }
}
