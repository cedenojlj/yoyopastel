<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {

            $table->id();
            $table->string('codigo');
            $table->string('nombre');
            $table->string('descripcion');
            $table->decimal('precio',8,2);
            $table->decimal('costo',8,2);
            $table->decimal('ganancia',8,2);            
            $table->integer('stock_min');                        
            $table->timestamps();
            $table->foreignId('categoria_id')->constrained('categorias')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
