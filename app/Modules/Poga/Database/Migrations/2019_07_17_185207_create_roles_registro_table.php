<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_registro', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_persona');
            $table->foreign('id_persona')->references('id')->on('personas');
            $table->enum('enum_rol', ['ADMINISTRADOR','CONSERJE','INQUILINO','PROPETARIO','PROVEEDOR']);
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->enum('enum_plan', ['PROPIEDADES_1_10','PROPIEDADES_11_20','PROPIEDADES_21_50','PROPIEDADES_51_100','PROPIEDADAES_101_250','PROPIEDADES_251_500'])->nullable();
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
        Schema::dropIfExists('roles_registro');
    }
}
