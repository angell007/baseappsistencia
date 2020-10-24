<?php

use Faker\Generator as Faker;

$factory->define(App\Funcionario::class, function (Faker $faker) {
    return [
        'identidad' => $faker->isbn10,
        'nombres' => $faker->name(),
        'apellidos' => $faker->lastName,
        'liquidado' => $faker->boolean($chanceOfGettingTrue = 20),
        'fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'lugar_nacimiento' => $faker->city,
        'tipo_sangre' => $faker->randomElement($array = array('A+','B+','AB+','A-')),
        'telefono' => $faker->tollFreePhoneNumber,
        'celular' => $faker->e164PhoneNumber ,   
        'email' => $faker->freeEmail,
        'direccion_residencia' => $faker->address,
        'estado_civil' => $faker->randomElement($array = array('Soltero(a)','Casado(a)','Divorciado(a)','Viudo(a)','Union Libre')),
        'grado_instruccion' => $faker->jobTitle,
        'titulo_estudio' => $faker->jobTitle,
        'salario' => $faker->randomNumber($nbDigits = 7, $strict = false),
        'subsidio_transporte' => $faker->boolean($chanceOfGettingTrue = 20),
        'fecha_ingreso' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'numero_hijos' => $faker->numberBetween(1,7),
        'image' => $faker->imageUrl($width = 640,$height = 480,'people'),
        'sexo' => $faker->randomElement( $array = array('Masculino','Femenino')),
        'jefe' => $faker->numberBetween(1,6),
        'riesgo_arl' => $faker->randomElement( $array = array('Riesgo 1','Riesgo 2', 'Riesgo 3', 'Riesgo 4', 'Riesgo 5')),
        'centro_costo_id' => $faker->numberBetween(1,6),
        'dependencia_id' => $faker->numberBetween(1,30),
        'cargo_id' => $faker->numberBetween(1,6),
        'turno_id' => $faker->numberBetween(1,6),
        'tipo_contrato_id' => $faker->numberBetween(1,10),
        'eps_id' => $faker->numberBetween(1,10),
        'pensiones_id' => $faker->numberBetween(1,3),
        'caja_compensacion_id' => $faker->numberBetween(1,5),
        'cesantias_id' => $faker->numberBetween(1,6),
        
    ];
});
