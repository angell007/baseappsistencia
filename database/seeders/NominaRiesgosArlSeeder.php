<?php

namespace Database\Seeders;


use App\Models\NominaRiesgosArl;
use Illuminate\Database\Seeder;

class NominaRiesgosArlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NominaRiesgosArl::create([
            'prefijo' => 'riesgo_uno',
            'concepto' => 'Riesgo ARL I',
            'porcentaje' => 0.00522
        ]);
        NominaRiesgosArl::create([
            'prefijo' => 'riesgo_dos',
            'concepto' => 'Riesgo ARL II',
            'porcentaje' => 0.01044
        ]);
        NominaRiesgosArl::create([
            'prefijo' => 'riesgo_tres',
            'concepto' => 'Riesgo ARL III',
            'porcentaje' => 0.0243
        ]);
        NominaRiesgosArl::create([
            'prefijo' => 'riesgo_cuatro',
            'concepto' => 'Riesgo ARL IV',
            'porcentaje' => 0.04350
        ]);
        NominaRiesgosArl::create([
            'prefijo' => 'riesgo_cinco',
            'concepto' => 'Riesgo ARL V',
            'porcentaje' => 0.06960
        ]);
    }
}
