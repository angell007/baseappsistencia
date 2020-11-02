<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('identidad')->unique()->default(0);
            $table->string('dv')->nullable(); 
            $table->string('nombres');
            $table->string('apellidos');
            $table->boolean('liquidado')->default(0);
            $table->date('fecha_nacimiento')->nullable();
            $table->text('lugar_nacimiento')->nullable();
            $table->enum('tipo_sangre', ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'])->nullable();
            $table->enum('tipo_turno', ['Fijo', 'Rotativo'])->nullable();
            $table->integer('turno_fijo_id')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->unique();
            $table->text('direccion_residencia')->nullable();
            $table->enum('estado_civil', ['Soltero(a)', 'Casado(a)', 'Divorciado(a)', 'Viudo(a)', 'Union Libre'])->nullable();
            $table->string('grado_instruccion')->nullable();
            $table->string('titulo_estudio')->nullable();
            $table->string('talla_pantalon')->nullable();
            $table->string('talla_bata')->nullable();
            $table->string('talla_botas')->nullable();
            $table->string('talla_camisa')->nullable();
            $table->string('image')->nullable();
            $table->integer('salario')->nullable();
            $table->boolean('subsidio_transporte')->default(0);
            $table->date('fecha_ingreso')->nullable();
            $table->integer('numero_hijos')->default(0);
            $table->string('personId')->nullable();
            $table->string('persistedFaceId')->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->enum('sexo', ['Femenino', 'Masculino'])->nullable();
            $table->unsignedInteger('dependencia_id')->index('funcionario_dependencia_id_foreign')->nullable();
            $table->unsignedInteger('cargo_id')->index('funcionario_cargo_id_foreign')->nullable();
            $table->timestamps();
            $table->unsignedInteger('eps_id')->index('funcionario_eps_id_foreign')->nullable();
            $table->unsignedInteger('cesantias_id')->index('funcionario_cesantias_id_foreign')->nullable();
            $table->unsignedInteger('pensiones_id')->index('funcionario_pensiones_id_foreign')->nullable();
            $table->unsignedInteger('caja_compensacion_id')->index('funcionario_caja_compensacion_id_foreign')->nullable();
            $table->unsignedInteger('tipo_contrato_id')->index('funcionario_tipo_contrato_id_foreign')->nullable();
            $table->unsignedInteger('nomina_riesgos_arl_id')->default(1)->index('funcionario_nomina_riesgos_arl_id_foreign')->nullable();
            $table->unsignedInteger('jefe_id')->nullable()->index('funcionario_jefe_id_foreign')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionario');
    }
}
