<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadesCoberturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciudades_cobertura', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_persona');
            $table->foreign('id_persona')->references('id')->on('personas');
            $table->unsignedInteger('id_ciudad');
            $table->foreign('id_ciudad')->references('id')->on('ciudades');
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->enum('enum_rol', ['ADMINISTRADOR','CONSERJE','INQUILINO','PROVEEDOR']);
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
        Schema::dropIfExists('ciudades_cobertura');
    }
}
