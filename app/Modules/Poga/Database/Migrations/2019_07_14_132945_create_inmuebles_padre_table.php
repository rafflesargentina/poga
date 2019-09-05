<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInmueblesPadreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inmuebles_padre', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_inmueble')->nullable();
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->unsignedInteger('id_direccion');
            $table->foreign('id_direccion')->references('id')->on('direcciones');
            $table->string('nombre', 50)->nullable();
            $table->tinyInteger('cant_pisos')->nullable();
            $table->boolean('divisible_en_unidades')->default(false);
            $table->string('modalidad_propiedad', 20);
            $table->tinyInteger('comision_administrador')->nullable();
            $table->unsignedInteger('monto_fondo_reserva')->default(0);
            $table->unsignedInteger('monto_fondo_expensas')->default(0);
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
        Schema::dropIfExists('inmuebles_padre');
    }
}
