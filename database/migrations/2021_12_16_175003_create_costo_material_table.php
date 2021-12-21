<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostoMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costo_material', function (Blueprint $table) {
            
            $table->id();

            $table->decimal('cantidad',12,2);
            
            $table->foreignId('costo_id')
            ->constrained('costos')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('material_id')
            ->constrained('materials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costo_material');
    }
}
