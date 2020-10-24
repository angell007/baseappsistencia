<?php

use Illuminate\Database\Seeder;
use App\NominaSeguridadSocialEmpresa;

class NominaSeguridadSocialEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NominaSeguridadSocialEmpresa::create([
            'prefijo' => 'salud',
            'concepto' => 'Salud',
            'porcentaje' => 0.085
        ]);
        NominaSeguridadSocialEmpresa::create([
            'prefijo' => 'pension',
            'concepto' => 'Pensión',
            'porcentaje' => 0.12
        ]);
      
    }
}
