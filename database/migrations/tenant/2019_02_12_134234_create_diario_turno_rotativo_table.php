<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiarioTurnoRotativoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diario_turno_rotativo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id');
            $table->date('fecha');
            $table->unsignedInteger('turno_rotativo_id');
            $table->time('hora_entrada_uno')->default('00:00:00');
            $table->time('hora_salida_uno')->default('00:00:00');
            $table->string('img_uno')->nullable();
            $table->string('img_dos')->nullable();
            $table->foreign('funcionario_id')->references('id')->on('funcionario')->onDelete('cascade');
            $table->foreign('turno_rotativo_id')->references('id')->on('turno_rotativo')->onDelete('cascade');
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
        Schema::dropIfExists('diario_turno_rotativo');
    }
}
