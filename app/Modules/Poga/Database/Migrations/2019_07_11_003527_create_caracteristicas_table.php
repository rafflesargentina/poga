<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaracteristicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracteristicas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tipo_caracteristica');
            $table->foreign('id_tipo_caracteristica')->references('id')->on('tipos_caracteristica');
            $table->string('nombre', 35);
            $table->string('descripcion', 100);
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
        Schema::dropIfExists('caracteristicas');
    }
}
