<?php

use Faker\Generator as Faker;

$factory->define(App\CentroCosto::class, function (Faker $faker) {
    return [
        'nombre' => $faker->bs,
        'codigo' => $faker->numberBetween(1,30),
        'prefijo_cuenta_contable' => $faker->numberBetween(50,70)

    ];
});
