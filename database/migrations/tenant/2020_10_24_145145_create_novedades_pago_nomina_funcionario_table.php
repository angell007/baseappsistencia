<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('pago_nomina_funcionario_id')->index('pg_nom_func_id_foreign');
            $table->string('concepto');
            $table->integer('dias');
            $table->integer('valor');
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
