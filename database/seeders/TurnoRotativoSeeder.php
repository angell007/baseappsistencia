<?php

namespace Database\Seeders;

use App\Models\TurnoRotativo;
use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\Types\Null_;

class TurnoRotativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TurnoRotativo::create([
            'nombre' => 'Mañana',
            'extras' => '1',
            'tolerancia_entrada' => '10',
            'tolerancia_salida' => '45',
            'hora_inicio_uno' => '06:00',
            'hora_fin_uno' => '14:00',
            'hora_inicio_dos' => Null,
            'hora_fin_dos' => Null,
            'jornada_turno' => 'Diurno',
            'color' => '#76D7C4',
        ]);
        TurnoRotativo::create([
            'nombre' => 'Tarde',
            'extras' => '1',
            'tolerancia_entrada' => '10',
            'tolerancia_salida' => '45',
            'hora_inicio_uno' => '14:00',
            'hora_fin_uno' => '22:00',
            'hora_inicio_dos' => Null,
            'hora_fin_dos' => Null,
            'jornada_turno' => 'Diurno',
            'color' => '#76D7C4',
        ]);
        TurnoRotativo::create([
            'nombre' => 'Noche',
            'extras' => '1',
            'tolerancia_entrada' => '10',
            'tolerancia_salida' => '45',
            'hora_inicio_uno' => '22:00',
            'hora_fin_uno' => '06:00',
            'hora_inicio_dos' => Null,
            'hora_fin_dos' => Null,
            'jornada_turno' => 'Diurno',
            'color' => '#76D7C4',
        ]);

    }
}
