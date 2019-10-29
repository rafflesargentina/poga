<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMantenimientosProgramadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos_programados', function (Blueprint $table) {
            $table->increments('id');
	    $table->unsignedInteger('id_mantenimiento');
	    $table->foreign('id_mantenimiento')->references('id')->on('mantenimientos')->onDelete('cascade');
	    $table->datetime('fecha_hora_programado');
	    $table->datetime('fecha_hora_anterior');
	    $table->enum('enum_estado', ['CONFIRMADO','INACTIVO','REALIZADO']);
	    $table->string('observacion')->nullable();
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
        Schema::dropIfExists('mantenimientos_programados');
    }
}
