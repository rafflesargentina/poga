<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_inmueble')->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->unsignedInteger('id_proveedor_servicio')->nullable();
            $table->foreign('id_proveedor_servicio')->references('id')->on('proveedor_servicio');
            $table->unsignedInteger('monto');
            $table->datetime('fecha_hora_programado');
            $table->string('descripcion');
            $table->boolean('repetir')->default(0);
            $table->enum('enum_estado', ['ACTIVO','INACTIVO','CONFIRMADO','REALIZADO']);
            $table->enum('enum_se_repite', ['TODOS_LOS_MESES','TODAS_LAS_SEMANAS','TODOS_LOS_ANNOS'])->nullable();
            $table->tinyInteger('repetir_cada')->nullable();
            $table->string('enum_dias_semana')->nullable();
            $table->date('fecha_terminacion_repeticion')->nullable();
            $table->unsignedInteger('id_caracteristica_inmueble')->nullable();
            $table->foreign('id_caracteristica_inmueble')->references('id')->on('caracteristica_inmueble');
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
        Schema::dropIfExists('mantenimientos');
    }
}
