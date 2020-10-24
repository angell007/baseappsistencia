<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('empresa_id')->nullable();
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
