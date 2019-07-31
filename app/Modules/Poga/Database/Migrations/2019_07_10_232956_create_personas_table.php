<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 25);
            $table->string('apellido', 25)->nullable();
            $table->enum('enum_tipo_persona', ['FISICA','JURIDICA']);
            $table->string('telefono', 20)->nullable();
            $table->string('direccion')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('enum_sexo', ['F','M'])->nullable();
            $table->string('ci', 15)->nullable();
            $table->string('ruc', 15)->nullable();
            $table->unsignedInteger('id_usuario_creador')->nullable();
            $table->foreign('id_usuario_creador')->references('id')->on('users');
            $table->string('mail_solicitudes', 128)->nullable();
            $table->string('cuenta_bancaria', 20)->nullable();
            $table->unsignedInteger('id_pais')->nullable();
            $table->foreign('id_pais')->references('id')->on('paises');
            $table->unsignedInteger('id_pais_cobertura')->nullable();
            $table->foreign('id_pais_cobertura')->references('id')->on('paises');
            $table->enum('enum_estado', ['ACTIVO','INACTIVO']);
            $table->string('mail', 128);
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
        Schema::dropIfExists('personas');
    }
}
