<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestaFuncionarioRespuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_funcionario_respuesta', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('encuesta_funcionario_id')->nullable();
            $table->integer('encuesta_pregunta_id')->nullable();
            $table->string('respuesta', 200)->nullable();
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
        Schema::dropIfExists('encuesta_funcionario_respuesta');
    }
}
