<?php

use Faker\Generator as Faker;

$factory->define(App\Cargo::class, function (Faker $faker) {
    return [
        'nombre' => $faker->jobTitle,
        'dependencia_id' => $faker->numberBetween(1,6)
    ];
});
