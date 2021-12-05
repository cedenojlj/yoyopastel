<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ParidadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'paridad' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 7),
        ];
    }
}
