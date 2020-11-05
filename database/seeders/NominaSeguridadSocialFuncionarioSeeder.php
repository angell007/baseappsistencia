<?php

namespace Database\Seeders;


use App\Models\NominaSeguridadSocialFuncionario;
use Illuminate\Database\Seeder;

class NominaSeguridadSocialFuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NominaSeguridadSocialFuncionario::create([
            'prefijo' => 'salud',
            'concepto' => 'Salud',
            'porcentaje' => 0.04
        ]);
        NominaSeguridadSocialFuncionario::create([
            'prefijo' => 'pension',
            'concepto' => 'Pensión',
            'porcentaje' => 0.04
        ]);
        NominaSeguridadSocialFuncionario::create([
            'prefijo' => 'fondo_solidaridad',
            'concepto' => 'Fondo de solidaridad',
            'porcentaje' => 0.01
        ]);
        NominaSeguridadSocialFuncionario::create([
            'prefijo' => 'fondo_subsistencia_02',
            'concepto' => 'Fondo de subsistencia 16 a 17 SMMLV',
            'porcentaje' => 0.002
        ]);
        NominaSeguridadSocialFuncionario::create([
            'prefijo' => 'fondo_subsistencia_04',
            'concepto' => 'Fondo de subsistencia 17 a 18 SMMLV',
            'porcentaje' => 0.004
        ]);
        NominaSeguridadSocialFuncionario::create([
            'prefijo' => 'fondo_subsistencia_06',
            'concepto' => 'Fondo de subsistencia 18 a 19 SMMLV',
            'porcentaje' => 0.006
        ]);
        NominaSeguridadSocialFuncionario::create([
            'prefijo' => 'fondo_subsistencia_08',
            'concepto' => 'Fondo de subsistencia 19 a 20 SMMLV',
            'porcentaje' => 0.008
        ]);
        NominaSeguridadSocialFuncionario::create([
            'prefijo' => 'fondo_subsistencia_1',
            'concepto' => 'Fondo de subsistencia mayor a 20 SMMLV',
            'porcentaje' => 0.01
        ]);
    }
}
