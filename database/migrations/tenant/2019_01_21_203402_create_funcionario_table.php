<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** Se indican nombres de campos sin tildes por temas de compatibilidad en los Motores de Bases de Datos - 34 campos */
        Schema::create('funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identidad')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->boolean('liquidado')->default(false);
            $table->date('fecha_nacimiento');
            $table->text('lugar_nacimiento')->nullable();
            $table->enum('tipo_sangre', ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']);
            $table->enum('tipo_turno', ['Fijo', 'Rotativo']);
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
            $table->integer('salario');
            $table->boolean('subsidio_transporte')->default(false);
            $table->date('fecha_ingreso');
            $table->integer('numero_hijos')->default(0);
            $table->string('personId')->nullable();
            $table->string('persistedFaceId')->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->enum('sexo', ['Femenino', 'Masculino']);
            $table->unsignedInteger('dependencia_id');
            $table->unsignedInteger('cargo_id');
            $table->foreign('dependencia_id')->references('id')->on('dependencia')->onDelete('cascade');
            $table->foreign('cargo_id')->references('id')->on('cargo')->onDelete('cascade');
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
        Schema::dropIfExists('funcionario');
    }
}
