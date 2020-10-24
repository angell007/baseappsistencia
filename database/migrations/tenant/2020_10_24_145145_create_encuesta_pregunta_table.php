<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestaPreguntaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_pregunta', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('encuesta_id')->nullable();
            $table->string('pregunta', 500)->nullable();
            $table->enum('tipo_pregunta', ['simple', 'simple-dos', 'multiple', 'respuesta-corta', 'respuesta-larga'])->default('simple');
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
        Schema::dropIfExists('encuesta_pregunta');
    }
}
