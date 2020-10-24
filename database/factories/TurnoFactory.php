<?php

use Faker\Generator as Faker;

$factory->define(App\Turno::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'extras' => $faker->boolean(),
        'tolerancia_entrada' => $faker->numberBetween(0,0),
        'tolerancia_salida' => $faker->numberBetween(0,0),
        'tipo_turno' => $faker->randomElement($array = array('Fijo','Rotativo')),
        'color' => $faker->randomElement($array = array('#D98880','#C39BD3','#7FB3D5','#85C1E9','#76D7C4','#F7DC6F','#F8C471','#E59866','#7D3C98','#A04000','#FACC2E','#81F7BE','#fda4a4','#f390bd','#e9bdff','#415dfe','#6fe423','#05cfb3','#81e73e','#ffe76b','#ff9b52','#a06b61','#727171','#5faee3')),
        'hora_inicio_uno' => $faker->time($format = 'H:i:s', $max = 'now'),
        'hora_fin_uno' => $faker->time($format = 'H:i:s', $max = 'now'),
        'jornada_turno' => $faker->randomElement($array = array('Diurno','Nocturno')),
        'dependencia_id' => $faker->numberBetween(1,6)
    ];
});
