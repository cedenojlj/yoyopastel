<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {


            $table->id();

            $table->date('fecha');
            $table->integer('factura');          
            
            $table->decimal('total');
            $table->decimal('paridad');
            $table->enum('moneda',['Bs','Usd'])->default('Bs');
            $table->enum('metodo',['Debito','Credito','Efectivo'])->default('Debito');                        

            $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('empresa_id')
            ->constrained('empresas')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('venta_id')
            ->constrained('ventas')
            ->onUpdate('cascade')
            ->onDelete('cascade');




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
        Schema::dropIfExists('cajas');
    }
}
