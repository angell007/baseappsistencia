<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->boolean('estado')->default(1);
            $table->boolean('editable')->default(1);
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
