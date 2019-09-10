<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposCaracteristicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos_caracteristica', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
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
        Schema::dropIfExists('grupos_caracteristica');
    }
}
