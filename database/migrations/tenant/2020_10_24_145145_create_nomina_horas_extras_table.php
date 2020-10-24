<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominaHorasExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomina_horas_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefijo');
            $table->string('concepto');
            $table->decimal('porcentaje', 4);
            $table->string('cuenta_contable')->default('0515');
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
        Schema::dropIfExists('nomina_horas_extras');
    }
}
