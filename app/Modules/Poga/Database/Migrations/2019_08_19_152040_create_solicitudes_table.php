<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_inmueble');
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->datetime('fecha_solicitud');
            $table->string('descripcion_solicitud');
            $table->enum('enum_estado', ['CONFIRMADO','INACTIVO','NO_REALIZADO','PENDIENTE','REALIZADO']);
            $table->unsignedInteger('id_usuario_creador');
            $table->foreign('id_usuario_creador')->references('id')->on('users');
            $table->string('descripcion_concluir')->nullable();
            $table->unsignedInteger('id_servicio');
            $table->foreign('id_servicio')->references('id')->on('servicios');
            $table->unsignedInteger('id_proveedor_servicio')->nullable();
            $table->foreign('id_proveedor_servicio')->references('id')->on('proveedor_servicio');
            $table->unsignedInteger('id_usuario_asigna')->nullable();
            $table->foreign('id_usuario_asigna')->references('id')->on('users');
            $table->datetime('fecha_fijada_respuesta')->nullable();
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
        Schema::dropIfExists('solicitudes');
    }
}
