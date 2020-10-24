<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('funcionario_id')->index('pago_provisiones_nomina_funcionario_funcionario_id_foreign');
            $table->unsignedInteger('pago_nomina_id')->index('pago_provisiones_nomina_funcionario_pago_nomina_id_foreign');
            $table->integer('cesantias');
            $table->integer('intereses_cesantias');
            $table->integer('prima');
            $table->integer('vacaciones');
            $table->double('dias_acumulados_vacaciones', 5, 3);
            $table->integer('total_provisiones');
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
