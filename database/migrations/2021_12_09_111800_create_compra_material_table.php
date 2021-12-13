<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_material', function (Blueprint $table) {

            $table->id();
            $table->decimal('cantidad');            
            $table->decimal('costo');            
            $table->decimal('subtotal');            
            $table->foreignId('compra_id')
            ->constrained('compras')
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
        Schema::dropIfExists('compra_material');
    }
}
