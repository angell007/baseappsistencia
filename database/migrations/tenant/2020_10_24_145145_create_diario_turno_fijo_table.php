<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('funcionario_id')->index('diario_turno_fijo_funcionario_id_foreign');
            $table->date('fecha');
            $table->unsignedInteger('turno_fijo_id')->index('diario_turno_fijo_turno_fijo_id_foreign');
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
            $table->timestamps();
            $table->decimal('temp_uno', 11, 1)->nullable()->default(36.4);
            $table->decimal('temp_dos', 11, 1)->nullable()->default(36.2);
            $table->decimal('temp_tres', 11, 1)->nullable()->default(36.7);
            $table->decimal('temp_cuatro', 11, 1)->nullable()->default(36.3);
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
