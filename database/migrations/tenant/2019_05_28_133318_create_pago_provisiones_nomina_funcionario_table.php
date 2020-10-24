<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoProvisionesNominaFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_provisiones_nomina_funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id');
            $table->unsignedInteger('pago_nomina_id');
            $table->integer('cesantias');
            $table->integer('intereses_cesantias');
            $table->integer('prima');
            $table->integer('vacaciones');
            $table->float('dias_acumulados_vacaciones', 5, 3);
            $table->integer('total_provisiones');
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
        Schema::dropIfExists('pago_provisiones_nomina_funcionario');
    }
}
