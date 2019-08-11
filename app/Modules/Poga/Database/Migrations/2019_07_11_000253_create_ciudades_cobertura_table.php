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
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('ciudades_cobertura');
    }
}
