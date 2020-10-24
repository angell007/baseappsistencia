<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRiesgoArlForeignInFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funcionario', function (Blueprint $table) {
            $table->unsignedInteger('nomina_riesgos_arl_id')->default(1);
            $table->foreign('nomina_riesgos_arl_id')->references('id')->on('nomina_riesgos_arl')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funcionario', function (Blueprint $table) {
            $table->dropForeign(['nomina_riesgos_arl_id_foreign']);
            $table->dropColumn('nomina_riesgos_arl_id');
        });
    }
}
