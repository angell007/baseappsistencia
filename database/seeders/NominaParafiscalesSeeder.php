<?php

namespace Database\Seeders;


use App\Models\NominaParafiscales;
use Illuminate\Database\Seeder;

class NominaParafiscalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NominaParafiscales::create([
            'prefijo' => 'sena',
            'concepto' => 'SENA',
            'porcentaje' => 0.02,
        ]);
        NominaParafiscales::create([
            'prefijo' => 'icbf',
            'concepto' => 'ICBF',
            'porcentaje' => 0.03,
        ]);
        NominaParafiscales::create([
            'prefijo' => 'caja_compensacion',
            'concepto' => 'Caja de compensación',
            'porcentaje' => 0.04,
        ]);
    }
}
