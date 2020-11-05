<?php

namespace Database\Seeders;


use App\Models\NominaHorasExtras;
use Illuminate\Database\Seeder;

class NominaHorasExtrasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NominaHorasExtras::create([
            'prefijo' => 'hed',
            'concepto' => 'Horas extras diurnas',
            'porcentaje' => 1.25,
        ]);
        NominaHorasExtras::create([
            'prefijo' => 'hen',
            'concepto' => 'Horas extras nocturnas',
            'porcentaje' => 1.75,
        ]);
        NominaHorasExtras::create([
            'prefijo' => 'hedfd',
            'concepto' => 'Horas extras dominicales y festivas',
            'porcentaje' => 2.0,
        ]);
        NominaHorasExtras::create([
            'prefijo' => 'hedfn',
            'concepto' => 'Horas extras nocturnas dom. y festivas',
            'porcentaje' => 2.5,
        ]);
        NominaHorasExtras::create([
            'prefijo' => 'rn',
            'concepto' => 'Recargos nocturnos',
            'porcentaje' => 0.35,
        ]);
        NominaHorasExtras::create([
            'prefijo' => 'rf',
            'concepto' => 'Recargos festivos',
            'porcentaje' => 0.75,
        ]);
    }
}
