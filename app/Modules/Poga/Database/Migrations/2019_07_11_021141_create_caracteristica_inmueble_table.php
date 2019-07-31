<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaracteristicaInmuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracteristica_inmueble', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_inmueble');
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->unsignedInteger('id_caracteristica')->nullable();
            $table->foreign('id_caracteristica')->references('id')->on('caracteristicas');
            $table->tinyInteger('cantidad')->nullable();
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->unsignedInteger('id_caracteristica_tipo_inmueble');
            $table->foreign('id_caracteristica_tipo_inmueble')->references('id')->on('caracteristica_tipo_inmueble');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caracteristica_inmueble_inmueble');
    }
}
