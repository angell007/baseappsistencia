<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContableIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contable_ingreso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concepto');
            $table->enum('tipo', ['Constitutivo', 'No Constitutivo']);
            $table->string('cuenta_contable');
            $table->boolean('estado')->default(true);
            $table->boolean('editable')->default(true);
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
        Schema::dropIfExists('contable_ingreso');
    }
}
