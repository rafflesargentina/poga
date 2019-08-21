<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_inmueble')->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->unsignedInteger('id_inmueble_padre');
            $table->foreign('id_inmueble_padre')->references('id')->on('inmuebles_padre');
            $table->unsignedInteger('id_espacio')->nullable();
            $table->foreign('id_espacio')->references('id')->on('espacios');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->unsignedInteger('id_usuario_creador');
            $table->foreign('id_usuario_creador')->references('id')->on('users');
            $table->enum('enum_tipo_evento', ['RESERVA','VISITA']);
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
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
        Schema::dropIfExists('eventos');
    }
}
