<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deduccion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id');
            $table->unsignedInteger('contable_deduccion_id');
            $table->foreign('funcionario_id')->references('id')->on('funcionario')->onDelete('cascade');
            $table->foreign('contable_deduccion_id')->references('id')->on('contable_deduccion')->onDelete('cascade');
            $table->integer('valor');
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
        Schema::dropIfExists('deduccion');
    }
}
