<?php

use Faker\Generator as Faker;

$factory->define(App\FuncionarioContactoEmergencia::class, function (Faker $faker) {
    return [
        'funcionario_id' => $faker->numberBetween(1,10),
        'parentesco' => $faker->randomElement($array = array('Hermano','Hermana','Primo','Prima','Madre','Padre')),
        'nombre_completo' => $faker->name,
        'telefono' => $faker->phoneNumber,
        'celular' => $faker->phoneNumber,
        'direccion' => $faker->address
    ];
});
