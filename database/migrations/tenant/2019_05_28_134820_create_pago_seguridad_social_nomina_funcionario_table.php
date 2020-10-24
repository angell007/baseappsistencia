<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoSeguridadSocialNominaFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_seguridad_social_nomina_funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id');
            $table->unsignedInteger('pago_nomina_id');
            $table->integer('salud');
            $table->integer('pension');
            $table->integer('riesgos');
            $table->integer('sena');
            $table->integer('icbf');
            $table->integer('caja_compensacion');
            $table->integer('total_seguridad_social');
            $table->integer('total_parafiscales');
            $table->integer('total_seguridad_social_parafiscales');
            $table->foreign('funcionario_id')->references('id')->on('funcionario')->onDelete('cascade');
            $table->foreign('pago_nomina_id')->references('id')->on('pago_nomina')->onDelete('cascade');
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
        Schema::dropIfExists('pago_seguridad_social_nomina_funcionario');
    }
}
