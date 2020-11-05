<?php

namespace Database\Seeders;


use App\Models\NominaIncapacidades;
use Illuminate\Database\Seeder;

class NominaIncapacidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NominaIncapacidades::create([
            'prefijo' => 'general',
            'concepto' => 'Incapacidad general',
            'porcentaje' => 0.66667
        ]);
        NominaIncapacidades::create([
            'prefijo' => 'laboral',
            'concepto' => 'Incapacidad laboral',
            'porcentaje' => 1.0
        ]);
    }
}
