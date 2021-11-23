<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->firstNameMale(),
            'apellido' => $this->faker->lastName(),
            'cedula' => $this->faker->ean8(),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'salario' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),            
            'foto' => $this->faker->imageUrl($width = 640, $height = 480),
            'empresa_id' => $this->faker->numberBetween($min = 1, $max = 50),
        ];
    }
}
