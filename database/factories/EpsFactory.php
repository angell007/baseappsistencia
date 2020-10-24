<?php

use Faker\Generator as Faker;

$factory->define(App\Eps::class, function (Faker $faker) {
    return [
        'nombre' => $faker->words(3,true),
        'nit' => $faker->isbn10,
        'cuenta_contable' => $faker->numberBetween(5000,6000),
    ];
});
