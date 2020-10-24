<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnoFijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turno_fijo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->boolean('extras');
            $table->integer('tolerancia_entrada');
            $table->integer('tolerancia_salida');
            $table->string('color');
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
        Schema::dropIfExists('turno_fijo');
    }
}
