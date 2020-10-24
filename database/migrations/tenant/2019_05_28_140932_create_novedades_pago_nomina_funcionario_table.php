<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovedadesPagoNominaFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novedades_pago_nomina_funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pago_nomina_funcionario_id');
            $table->string('concepto');
            $table->integer('dias');
            $table->integer('valor');
            $table->foreign('pago_nomina_funcionario_id', 'pg_nom_func_id_foreign')->references('id')->on('pago_nomina_funcionario')->onDelete('cascade');
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
        Schema::dropIfExists('novedades_pago_nomina_funcionario');
    }
}
