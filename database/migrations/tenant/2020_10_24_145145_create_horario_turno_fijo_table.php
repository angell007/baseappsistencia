<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorarioTurnoFijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_turno_fijo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dia');
            $table->unsignedInteger('turno_fijo_id')->index('horario_turno_fijo_turno_fijo_id_foreign');
            $table->string('hora_inicio_uno');
            $table->string('hora_fin_uno');
            $table->enum('jornada_turno', ['Diurno', 'Nocturno'])->default('Diurno');
            $table->string('hora_inicio_dos')->nullable();
            $table->string('hora_fin_dos')->nullable();
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
        Schema::dropIfExists('horario_turno_fijo');
    }
}
