<?php

use Faker\Generator as Faker;

$factory->define(App\Dependencia::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'centro_costo_id' => $faker->numberBetween(1,6)
    ];
});
