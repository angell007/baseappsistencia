<?php

use Faker\Generator as Faker;

$factory->define(App\TipoContrato::class, function (Faker $faker) {
    return [
        'nombre' => $faker->sentence($nbWords=2)
    ];
});
