<?php

use Illuminate\Database\Seeder;
use App\NominaIncapacidades;

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
            'Concepto' => 'Incapacidad general',
            'porcentaje' => 0.66667
        ]);
        NominaIncapacidades::create([
            'prefijo' => 'laboral',
            'Concepto' => 'Incapacidad laboral',
            'porcentaje' => 1.0
        ]);
    }
}
