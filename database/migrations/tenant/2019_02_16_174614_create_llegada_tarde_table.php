<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedInteger('funcionario_id');
            $table->date('fecha');
            $table->integer('tiempo')->nullable();
            $table->time('entrada_turno');
            $table->time('entrada_real');
            $table->boolean('cuenta');
            $table->string('justificacion')->nullable();
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
        Schema::dropIfExists('llegada_tarde');
    }
}
