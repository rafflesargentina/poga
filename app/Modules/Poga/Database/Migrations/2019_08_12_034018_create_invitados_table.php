<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_evento');
            $table->foreign('id_evento')->references('id')->on('eventos');
            $table->string('nombre');
            $table->string('apellidos')->nullable();
            $table->string('ci');
            $table->string('observacion');
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
        Schema::dropIfExists('invitados');
    }
}
