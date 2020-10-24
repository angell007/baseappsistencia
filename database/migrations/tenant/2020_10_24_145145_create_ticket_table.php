<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamp('fecha')->nullable()->useCurrent();
            $table->string('tipo', 100)->nullable();
            $table->string('cliente', 100)->nullable();
            $table->string('estado', 100)->nullable();
            $table->string('funcionario', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
}
