<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInmueblePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inmueble_persona', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_persona');
            $table->foreign('id_persona')->references('id')->on('personas');
            $table->unsignedInteger('id_inmueble');
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->boolean('referente')->default(false);
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->enum('enum_rol', ['ADMINISTRADOR','CONSERJE','INQUILINO','PROPIETARIO','PROVEEDOR']);
            $table->date('fecha_inicio_contrato')->nullable();
            $table->date('fecha_fin_contrato')->nullable();
            $table->unsignedInteger('salario')->nullable();
            $table->unsignedInteger('id_moneda_salario')->nullable();
            $table->tinyInteger('dia_cobro_mensual')->nullable();
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
        Schema::dropIfExists('inmueble_persona');
    }
}
