<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory(10)->create();
        \App\Models\Empresa::factory(50)->create();
        \App\Models\Empleado::factory(50)->create();
        \App\Models\Cliente::factory(50)->create();
        \App\Models\Proveedor::factory(50)->create();
        \App\Models\Categoria::factory(10)->create();
        
    }
}
