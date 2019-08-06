<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultasRentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multas_rentas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_renta');
            $table->foreign('id_renta')->references('id')->on('rentas');
            $table->unsignedInteger('id_pagare');
            $table->foreign('id_pagare')->references('id')->on('pagares');
            $table->unsignedInteger('mes');
            $table->unsignedInteger('anno');
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
        Schema::dropIfExists('multas_rentas');
    }
}
