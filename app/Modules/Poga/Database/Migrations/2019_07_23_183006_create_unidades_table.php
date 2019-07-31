<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_inmueble');
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->tinyInteger('piso');
            $table->string('numero', 10);
            $table->unsignedInteger('id_medida');
            $table->foreign('id_medida')->references('id')->on('medidas');
            $table->decimal('area');
            $table->unsignedInteger('id_inmueble_padre');
            $table->foreign('id_inmueble_padre')->references('id')->on('inmuebles_padre');
            $table->unsignedInteger('id_formato_inmueble');
            $table->decimal('area_estacionamiento')->nullable();
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
        Schema::dropIfExists('unidades');
    }
}
