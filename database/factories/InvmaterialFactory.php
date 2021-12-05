<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvmaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'entrada' => $this->faker->numberBetween($min = 1, $max = 50),
            'salida' => $this->faker->numberBetween($min = 1, $max = 40),
            'material_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'user_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'empresa_id' => $this->faker->numberBetween($min = 1, $max = 50),
        
        ];
    }
}
