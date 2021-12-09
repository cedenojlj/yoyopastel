<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {

            $table->id();
            $table->string('factura');
            $table->decimal('subtotal');
            $table->decimal('iva');
            $table->decimal('total');

            $table->foreignId('proveedor_id')
            ->constrained('proveedors')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('empresa_id')
            ->constrained('empresas')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
