<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNovedadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novedad', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id')->index('novedad_funcionario_id_foreign');
            $table->unsignedInteger('contable_licencia_incapacidad_id')->index('novedad_contable_licencia_incapacidad_id_foreign');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->string('tipo');
            $table->string('modalidad');
            $table->text('observacion')->nullable();
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
        Schema::dropIfExists('novedad');
    }
}
