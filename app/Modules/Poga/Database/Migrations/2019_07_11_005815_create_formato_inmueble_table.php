<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatoInmuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formato_inmueble', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_inmueble');
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->unsignedInteger('id_formato');
            $table->foreign('id_formato')->references('id')->on('formatos');
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formato_inmueble');
    }
}
