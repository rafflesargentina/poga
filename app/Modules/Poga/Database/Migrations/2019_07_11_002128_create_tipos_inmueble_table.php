<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposInmuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_inmueble', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo', 15);
            $table->string('descripcion', 50)->nullable();
            $table->enum('enum_aplica_a', ['INMUEBLES','UNIDADES']);
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->boolean('configurable_division_unidades')->default(false);
            $table->tinyInteger('cant_pisos_fija')->nullable();
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
        Schema::dropIfExists('tipos_inmueble');
    }
}
