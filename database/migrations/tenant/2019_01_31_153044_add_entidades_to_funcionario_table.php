<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntidadesToFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funcionario', function (Blueprint $table) {
            $table->unsignedInteger('eps_id');
            $table->unsignedInteger('cesantias_id');
            $table->unsignedInteger('pensiones_id');
            $table->unsignedInteger('caja_compensacion_id');
            $table->foreign('eps_id')->references('id')->on('eps')->onDelete('cascade');
            $table->foreign('cesantias_id')->references('id')->on('cesantias')->onDelete('cascade');
            $table->foreign('pensiones_id')->references('id')->on('pensiones')->onDelete('cascade');
            $table->foreign('caja_compensacion_id')->references('id')->on('caja_compensacion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funcionario', function (Blueprint $table) {
            $table->dropForeign(['eps_id']);
            $table->dropForeign(['cesantias_id']);
            $table->dropForeign(['pensiones_id']);
            $table->dropForeign(['caja_compensacion_id']);
            $table->dropColumn('eps_id');
            $table->dropColumn('cesantias_id');
            $table->dropColumn('pensiones_id');
            $table->dropColumn('caja_compensacion_id');
        });
    }
}
