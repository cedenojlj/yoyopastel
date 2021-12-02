<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'codigo' => $this->faker->ean8(),
            'nombre' => $this->faker->name(),
            'descripcion' => $this->faker->text($maxNbChars = 50),
            'precio' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 40, $max = 210),
            'costo' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 5, $max = 35),
            'ganancia' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 100),
            'stock' => $this->faker->numberBetween($min = 1, $max = 20),
            'stock_min' => $this->faker->numberBetween($min = 1, $max = 10),
            'categoria_id' => $this->faker->numberBetween($min = 1, $max = 10),
        ];
    }
}
