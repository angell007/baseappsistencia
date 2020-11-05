<?php

namespace Database\Seeders;

use App\Models\HorarioTurnoFijo;
use Illuminate\Database\Seeder;

class HorarioTurnoFijoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HorarioTurnoFijo::create([
            'dia' => 'Lunes',
            'turno_fijo_id' => 1,
            'hora_inicio_uno' => '8:00',
            'hora_fin_uno' => '11:45',
            'jornada_turno' => 'Diurno',
            'hora_inicio_dos' => '14:00',
            'hora_fin_dos' => '18:00',
        ]);
        HorarioTurnoFijo::create([
            'dia' => 'Martes',
            'turno_fijo_id' => 1,
            'hora_inicio_uno' => '8:00',
            'hora_fin_uno' => '11:45',
            'jornada_turno' => 'Diurno',
            'hora_inicio_dos' => '14:00',
            'hora_fin_dos' => '18:00',
        ]);
        HorarioTurnoFijo::create([
            'dia' => 'Jueves',
            'turno_fijo_id' => 1,
            'hora_inicio_uno' => '8:00',
            'hora_fin_uno' => '11:45',
            'jornada_turno' => 'Diurno',
            'hora_inicio_dos' => '14:00',
            'hora_fin_dos' => '18:00',
        ]);
        HorarioTurnoFijo::create([
            'dia' => 'Viernes',
            'turno_fijo_id' => 1,
            'hora_inicio_uno' => '8:00',
            'hora_fin_uno' => '11:45',
            'jornada_turno' => 'Diurno',
            'hora_inicio_dos' => '14:00',
            'hora_fin_dos' => '18:00',
        ]);
        HorarioTurnoFijo::create([
            'dia' => 'Sábado',
            'turno_fijo_id' => 1,
            'hora_inicio_uno' => '8:00',
            'hora_fin_uno' => '11:45',
            'jornada_turno' => 'Diurno',
            'hora_inicio_dos' => '14:00',
            'hora_fin_dos' => '18:00',
        ]);
    }
}
