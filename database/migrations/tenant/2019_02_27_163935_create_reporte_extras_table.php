<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReporteExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporte_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id');
            $table->date('fecha');
            $table->integer('ht');
            $table->integer('hed');
            $table->integer('hen');
            $table->integer('hedfd');
            $table->integer('hedfn');
            $table->integer('rn');
            $table->integer('rf');
            $table->integer('hed_reales');
            $table->integer('hen_reales');
            $table->integer('hedfd_reales');
            $table->integer('hedfn_reales');
            $table->integer('rn_reales');
            $table->integer('rf_reales');
            $table->foreign('funcionario_id')->references('id')->on('funcionario')->onDelete('cascade');
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
        Schema::dropIfExists('reporte_extras');
    }
}
