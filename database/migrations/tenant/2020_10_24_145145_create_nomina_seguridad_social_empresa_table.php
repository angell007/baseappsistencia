<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominaSeguridadSocialEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomina_seguridad_social_empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefijo');
            $table->string('concepto');
            $table->decimal('porcentaje', 5, 3);
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
        Schema::dropIfExists('nomina_seguridad_social_empresa');
    }
}
