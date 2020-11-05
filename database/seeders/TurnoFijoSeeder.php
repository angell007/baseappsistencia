<?php

namespace Database\Seeders;

use App\Models\TurnoFijo;
use Illuminate\Database\Seeder;

class TurnoFijoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TurnoFijo::create([
            'nombre' => 'Horario Habitual',
            'extras' => '0',
            'tolerancia_entrada' =>'10',
            'tolerancia_salida' =>'45',
            'color' => '#81F7BE'
        ]);
    }
}

