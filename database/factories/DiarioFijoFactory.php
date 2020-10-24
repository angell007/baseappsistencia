<?php

use Faker\Generator as Faker;

$factory->define(App\DiarioFijo::class, function (Faker $faker) {
    return [
        'funcionario_id' => $faker->numberBetween(1,28),
        'fecha' => $faker->randomElement($array = array('2019-02-01','2019-02-02','2019-02-03','2019-02-04','2019-02-05', '2019-02-06','2019-02-07','2019-02-08','2019-02-09','2019-02-10','2019-02-11','2019-02-12')),
        'turno_id' => $faker->numberBetween(1,10),
        'hora_entrada_uno' => $faker->randomElement($array = array('06:01:55','06:04:47','06:16:27','06:32:08')), 
        'hora_salida_uno' => $faker->randomElement($array = array('13:25:13','12:12:07','12:01:50','12:06:20')), 
        'hora_entrada_dos' =>$faker->randomElement($array = array('13:29:15','14:00:05','12:36:50','14:03:10')), 
        'hora_salida_dos' => $faker->randomElement($array = array('18:05:39','19:33:05','18:55:55','18:14:30')),
        'latitud' => $faker->randomElement($array = array('7.085428','7.0510258','7.125078')),
        'longitud' => $faker->randomElement($array = array('-73.139710','-73.0831379')),
        'latitud_dos' => $faker->randomElement($array = array('7.085428','7.0510258','7.125078')),
        'longitud_dos' => $faker->randomElement($array = array('-73.139710','-73.0831379')),
        'latitud_tres' => $faker->randomElement($array = array('7.085428','7.0510258','7.125078')),
        'longitud_tres' => $faker->randomElement($array = array('-73.139710','-73.0831379')),
        'latitud_cuatro' => $faker->randomElement($array = array('7.085428','7.0510258','7.125078')),
        'longitud_cuatro' => $faker->randomElement($array = array('-73.139710','-73.0831379')),
    ];
});
