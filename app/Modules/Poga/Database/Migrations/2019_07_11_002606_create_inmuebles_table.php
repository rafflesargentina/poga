<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInmueblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inmuebles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tipo_inmueble');
            $table->foreign('id_tipo_inmueble')->references('id')->on('tipos_inmueble');
            $table->boolean('solicitud_directa_inquilinos')->default(false);
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->enum('enum_tabla_hija', ['INMUEBLES_PADRE','UNIDADES']);
            $table->unsignedInteger('id_tabla_hija')->nullable();
            $table->unsignedInteger('id_usuario_creador')->nullable();
            $table->foreign('id_usuario_creador')->references('id')->on('users');
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
        Schema::dropIfExists('inmuebles');
    }
}
