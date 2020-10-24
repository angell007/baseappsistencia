<?php

use Faker\Generator as Faker;

$factory->define(App\Cesantia::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word
    ];
});
