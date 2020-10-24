<?php

use Faker\Generator as Faker;

$factory->define(App\FuncionarioExperienciaLaboral::class, function (Faker $faker) {
    return [
        'funcionario_id' => $faker->numberBetween(1,10),
        'nombre_empresa' => $faker->company,
        'cargo' => $faker->jobTitle,
        'labores' => $faker->paragraph(3),
        'telefono_empresa' => $faker->phoneNumber

    ];
});
