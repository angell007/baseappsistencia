<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLlegadaTardeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('llegada_tarde', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id')->index('llegada_tarde_funcionario_id_foreign');
            $table->date('fecha');
            $table->integer('tiempo')->nullable();
            $table->time('entrada_turno');
            $table->time('entrada_real');
            $table->boolean('cuenta');
            $table->string('justificacion')->nullable();
            $table->timestamps();
            $table->integer('dependencia_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('llegada_tarde');
    }
}
