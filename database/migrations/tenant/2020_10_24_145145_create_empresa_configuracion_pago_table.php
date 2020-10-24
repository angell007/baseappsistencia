<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaConfiguracionPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_configuracion_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->string('calculo_incapacidad_general');
            $table->string('pago_deducciones');
            $table->string('pago_recurrente');
            $table->string('pago_subsidio_transporte');
            $table->boolean('afecta_subsidio_transporte');
            $table->boolean('pagar_vacaciones_31')->default(0);
            $table->unsignedInteger('empresa_id')->index('empresa_configuracion_pago_empresa_id_foreign');
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
        Schema::dropIfExists('empresa_configuracion_pago');
    }
}
