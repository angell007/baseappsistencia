<?php

use Faker\Generator as Faker;

$factory->define(App\CajaCompensacion::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'nit' => $faker->isbn10,
        'cuenta_contable' => $faker->numberBetween(5000,6000),
    ];
});
