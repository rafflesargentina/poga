<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_pagado');
	    $table->enum('enum_medio_pago', ['EFECTIVO', 'GIROS_TIGO', 'TARJETA_DE_CREDITO', 'TARJETA_DE_DEBITO', 'TRANSFERENCIA_BANCARIA']);
	    $table->string('banco')->nullable();
            $table->string('nro_operacion', 100)->nullable();
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
        Schema::dropIfExists('facturas');
    }
}
