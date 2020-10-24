<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoNominaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_nomina', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->nullable()->index('pago_nomina_admin_id_foreign');
            $table->date('inicio_periodo');
            $table->date('fin_periodo');
            $table->integer('total_salarios');
            $table->integer('total_retenciones');
            $table->integer('total_provisiones');
            $table->integer('total_seguridad_social');
            $table->integer('total_parafiscales');
            $table->integer('total_extras_recargos');
            $table->integer('total_ingresos');
            $table->integer('costo_total');
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
        Schema::dropIfExists('pago_nomina');
    }
}
