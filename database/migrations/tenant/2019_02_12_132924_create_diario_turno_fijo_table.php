<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiarioTurnoFijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diario_turno_fijo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id');
            $table->date('fecha');
            $table->unsignedInteger('turno_fijo_id');
            $table->time('hora_entrada_uno')->default('00:00:00');
            $table->time('hora_salida_uno')->default('00:00:00');
            $table->time('hora_entrada_dos')->default('00:00:00');
            $table->time('hora_salida_dos')->default('00:00:00');
            $table->string('img_uno')->nullable();
            $table->string('img_dos')->nullable();
            $table->string('img_tres')->nullable();
            $table->string('img_cuatro')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->string('latitud_dos')->nullable();
            $table->string('longitud_dos')->nullable();
            $table->string('latitud_tres')->nullable();
            $table->string('longitud_tres')->nullable();
            $table->string('latitud_cuatro')->nullable();
            $table->string('longitud_cuatro')->nullable();
            $table->foreign('funcionario_id')->references('id')->on('funcionario')->onDelete('cascade');
            $table->foreign('turno_fijo_id')->references('id')->on('turno_fijo')->onDelete('cascade');
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
        Schema::dropIfExists('diario_turno_fijo');
    }
}
