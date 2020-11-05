<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nit', 100)->nullable();
            $table->string('nombre', 200)->nullable();
            $table->integer('empleados_activos')->nullable();
            $table->string('tipo_negocio', 100)->nullable();
            $table->integer('valor_contrato')->nullable();
            $table->integer('total_mes')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->date('fecha_renovacion')->nullable();
            $table->string('tipo_pago', 100)->nullable();
            $table->string('estado')->nullable();
            $table->string('ruta')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
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
        Schema::dropIfExists('cliente');
    }
}
