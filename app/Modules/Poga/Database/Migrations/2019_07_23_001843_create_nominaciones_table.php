<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario_principal');
            $table->foreign('id_usuario_principal')->references('id')->on('users');
            $table->unsignedInteger('id_persona_nominada');
            $table->foreign('id_persona_nominada')->references('id')->on('personas');
            $table->unsignedInteger('id_inmueble');
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->unsignedInteger('role_id');
            $table->datetime('fecha_hora');
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->unsignedInteger('usu_alta');
            $table->unsignedInteger('usu_mod')->nullable();
            $table->unsignedInteger('usu_elim')->nullable();
            $table->boolean('referente')->default(false);
            $table->string('codigo_validacion', 50)->nullable();
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
        Schema::dropIfExists('nominaciones');
    }
}
