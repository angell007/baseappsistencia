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
            $table->date('imagen')->nullable();
            $table->enum('tipo_documento', ['NIT', 'Cédula de ciudadanía', 'Cédula de extranjería', 'Tarjeta de identidad']);
            $table->string('numero_documento');
            $table->date('fecha_constitucion')->nullable();
            $table->string('email_contacto')->unique();
            $table->string('telefono_contacto')->nullable();
            $table->integer('max_horas_extras')->default(0);
            $table->integer('max_festivos_legales')->default(0);
            $table->integer('max_llegadas_tarde')->default(0);
            $table->integer('salario_base')->nullable();
            $table->integer('auxilio_transporte')->nullable();
            $table->string('hora_inicio_noche')->nullable();
            $table->string('hora_fin_noche')->nullable();
            $table->text('festivos')->nullable();
            $table->string('frecuencia_pago')->nullable();
            $table->string('medio_pago')->nullable();
            $table->string('tipo_cuenta')->nullable();
            $table->string('numero_cuenta')->nullable();
            $table->string('operador_pago')->nullable();
            $table->boolean('ley_1429')->default(0);
            $table->boolean('ley_590')->default(0);
            $table->boolean('ley_1607')->default(1);
            $table->timestamps();
            $table->unsignedInteger('arl_id')->index('empresa_arl_id_foreign')->nullable();
            $table->unsignedInteger('banco_id')->index('empresa_banco_id_foreign')->nullable();
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
