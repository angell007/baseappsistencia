<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('funcionario_id')->index('pago_seguridad_social_nomina_funcionario_funcionario_id_foreign');
            $table->unsignedInteger('pago_nomina_id')->index('pago_seguridad_social_nomina_funcionario_pago_nomina_id_foreign');
            $table->integer('salud');
            $table->integer('pension');
            $table->integer('riesgos');
            $table->integer('sena');
            $table->integer('icbf');
            $table->integer('caja_compensacion');
            $table->integer('total_seguridad_social');
            $table->integer('total_parafiscales');
            $table->integer('total_seguridad_social_parafiscales');
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
