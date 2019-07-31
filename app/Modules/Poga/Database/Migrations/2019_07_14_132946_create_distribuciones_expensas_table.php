<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribucionesExpensasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribuciones_expensas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_distribucion');
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->enum('enum_criterio', ['METROS_CUADRADOS','EQUITATIVO']);
            $table->unsignedInteger('id_inmueble_padre');
            $table->foreign('id_inmueble_padre')->references('id')->on('inmuebles_padre');
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
        Schema::dropIfExists('distribuciones_expensas');
    }
}
