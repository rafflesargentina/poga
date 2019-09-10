<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaracteristicaTipoInmuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracteristica_tipo_inmueble', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tipo_inmueble');
            $table->foreign('id_tipo_inmueble')->references('id')->on('tipos_inmueble');
            $table->unsignedInteger('id_caracteristica');
            $table->foreign('id_caracteristica')->references('id')->on('caracteristicas');
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->unsignedInteger('id_grupo_caracteristica')->nullable();
            $table->foreign('id_grupo_caracteristica')->references('id')->on('grupos_caracteristica');
            $table->unsignedInteger('id_tipo_caracteristica');
            $table->foreign('id_tipo_caracteristica')->references('id')->on('tipos_caracteristica');
            $table->enum('enum_tipo_campo', ['boolean','number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caracteristica_tipo_inmueble');
    }
}
