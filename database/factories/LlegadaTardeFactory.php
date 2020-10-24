<?php

use Faker\Generator as Faker;

$factory->define(App\LlegadaTarde::class, function (Faker $faker) {
    return [
        'funcionario_id' => $faker->numberBetween(1,28),
        'centro_costo_id' => $faker->numberBetween(1,10),
        'dependencia_id' => $faker->numberBetween(1,30),
        'fecha' => $faker->randomElement($array = array('2019-02-01','2019-02-02','2019-02-03','2019-02-04','2019-02-05','2019-02-06','2019-02-07','2019-02-08','2019-02-09','2019-02-10','2019-02-11','2019-02-12','2019-02-13','2019-02-14','2019-02-15','2019-02-16')),
        'entrada_turno' => $faker->randomElement($array = array('08:00:00')),
        'entrada_real' => $faker->randomElement($array=array('08:01:15','08:03:15','08:05:35','08:02:22','08:00:10','08:06:32','08:23:46','08:16:14','08:01:27','08:04:54','08:06:17','08:00:55')),
        'cuenta' => $faker->boolean(true),


    ];
});
