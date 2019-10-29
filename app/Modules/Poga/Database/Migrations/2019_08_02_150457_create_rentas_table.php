<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentasTable extends Migration
{
   
    public function up()
    {
        Schema::create('rentas', function (Blueprint $table) {
            $table->increments('id');            
            $table->unsignedInteger('id_inmueble');
            $table->foreign('id_inmueble')->references('id')->on('inmuebles');
            $table->unsignedInteger('monto');         
            $table->unsignedInteger('prim_comision_administrador');
            $table->unsignedInteger('comision_administrador');
            $table->date('fecha_fin');
            $table->date('fecha_inicio');
            $table->boolean('multa');
            $table->boolean('expensas');
            $table->tinyInteger('dias_multa')->nullable();
            $table->unsignedInteger('monto_multa_dia')->nullable();
            $table->enum('enum_estado', ['ACTIVO','INACTIVO','PENDIENTE','FINALIZADO']);
            $table->unsignedInteger('id_moneda');
            $table->foreign('id_moneda')->references('id')->on('monedas');
            $table->unsignedInteger('id_inquilino');
            $table->foreign('id_inquilino')->references('id')->on('personas');
            $table->unsignedInteger('garantia');
            $table->unsignedInteger('dia_mes_pago');
            $table->date('fecha_finalizacion_contrato')->nullable();            
            $table->unsignedInteger('monto_descontado_garantia_finalizacion_contrato')->nullable();
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
        Schema::dropIfExists('rentas');
    }
}
