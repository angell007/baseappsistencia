<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestaFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_funcionario', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamp('fecha')->nullable()->useCurrent();
            $table->integer('funcionario_id')->nullable();
            $table->integer('encuesta_id')->nullable();
            $table->string('lat', 50)->nullable();
            $table->string('lon', 50)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encuesta_funcionario');
    }
}
