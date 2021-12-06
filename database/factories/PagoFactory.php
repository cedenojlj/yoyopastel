<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            'pago' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 40, $max = 210),
            'referencia' => $this->faker->ean8(),
            'concepto' => $this->faker->text($maxNbChars = 50),
            'user_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'empresa_id' => $this->faker->numberBetween($min = 1, $max = 50),
        ];
    }
}
