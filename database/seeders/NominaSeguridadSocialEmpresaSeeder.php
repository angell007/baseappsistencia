<?php

namespace Database\Seeders;


use App\Models\NominaSeguridadSocialEmpresa;
use Illuminate\Database\Seeder;

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
