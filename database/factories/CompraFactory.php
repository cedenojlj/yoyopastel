<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            'fecha'=>$this->faker->date(),
            'factura'=>$this->faker->ean8(),
            'subtotal'=>$this->faker->randomFloat(2,5,100),
            'iva'=>$this->faker->randomFloat(2,1,12),
            'total'=>$this->faker->randomFloat(2,110,200),
            'proveedor_id'=>$this->faker->numberBetween(1,10),
            'user_id'=>$this->faker->numberBetween(1,10),
            'empresa_id'=>$this->faker->numberBetween(1,10)

        ];
    }
}
