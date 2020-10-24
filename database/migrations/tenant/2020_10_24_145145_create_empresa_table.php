<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razon_social');
            $table->enum('tipo_documento', ['NIT', 'Cédula de ciudadanía', 'Cédula de extranjería', 'Tarjeta de identidad']);
            $table->string('numero_documento');
            $table->date('fecha_constitucion');
            $table->string('email_contacto')->unique();
            $table->string('telefono_contacto')->nullable();
            $table->integer('max_horas_extras')->default(0);
            $table->integer('max_festivos_legales')->default(0);
            $table->integer('max_llegadas_tarde')->default(0);
            $table->integer('salario_base');
            $table->integer('auxilio_transporte');
            $table->string('hora_inicio_noche');
            $table->string('hora_fin_noche');
            $table->text('festivos')->nullable();
            $table->string('frecuencia_pago');
            $table->string('medio_pago');
            $table->string('tipo_cuenta');
            $table->string('numero_cuenta');
            $table->string('operador_pago');
            $table->boolean('ley_1429')->default(0);
            $table->boolean('ley_590')->default(0);
            $table->boolean('ley_1607')->default(1);
            $table->timestamps();
            $table->unsignedInteger('arl_id')->index('empresa_arl_id_foreign');
            $table->unsignedInteger('banco_id')->index('empresa_banco_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}
