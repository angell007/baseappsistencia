<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoNominaFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_nomina_funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id')->index('pago_nomina_funcionario_funcionario_id_foreign');
            $table->unsignedInteger('pago_nomina_id')->index('pago_nomina_funcionario_pago_nomina_id_foreign');
            $table->integer('dias_trabajados');
            $table->integer('salario');
            $table->integer('auxilio_transporte')->nullable()->default(0);
            $table->integer('retenciones_deducciones');
            $table->integer('salario_neto');
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
        Schema::dropIfExists('pago_nomina_funcionario');
    }
}
