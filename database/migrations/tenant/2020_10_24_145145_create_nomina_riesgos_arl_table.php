<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominaRiesgosArlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomina_riesgos_arl', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefijo');
            $table->string('concepto');
            $table->decimal('porcentaje', 6, 5);
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
        Schema::dropIfExists('nomina_riesgos_arl');
    }
}
