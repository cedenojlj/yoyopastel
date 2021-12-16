<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CostoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            'producto_id'=>$this->faker->numberBetween(1,50),
            'user_id'=>$this->faker->numberBetween(1,10),
            'empresa_id'=>$this->faker->numberBetween(1,50)
        ];
    }
}
