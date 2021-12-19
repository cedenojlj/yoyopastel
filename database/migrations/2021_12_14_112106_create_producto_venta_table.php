<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_venta', function (Blueprint $table) {
            
            $table->id();
            $table->decimal('cantidad');            
            $table->decimal('precio');            
            $table->decimal('costo');            
            $table->decimal('subtotal');
            $table->decimal('subcosto');
            $table->foreignId('venta_id')
            ->constrained('ventas')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('producto_id')
            ->constrained('productos')
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
        Schema::dropIfExists('producto_venta');
    }
}
