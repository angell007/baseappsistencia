<?php

namespace Database\Seeders;


use App\Models\ContableLicenciaIncapacidad;
use Illuminate\Database\Seeder;

class ContableLicenciaIncapacidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContableLicenciaIncapacidad::create([
            'concepto' => 'Incapacidad laboral',
            'cuenta_contable' => '0524',
            'estado' => true
        ]);
        ContableLicenciaIncapacidad::create([
            'concepto' => 'Incapacidad general',
            'cuenta_contable' => '0524',
            'estado' => true
        ]);
        ContableLicenciaIncapacidad::create([
            'concepto' => 'Licencia de maternidad',
            'cuenta_contable' => '0524',
            'estado' => true
        ]);
        ContableLicenciaIncapacidad::create([
            'concepto' => 'Licencia de paternidad',
            'cuenta_contable' => '0524',
            'estado' => true
        ]);
        ContableLicenciaIncapacidad::create([
            'concepto' => 'Abandono del puesto de trabajo',
            'cuenta_contable' => '0506',
            'estado' => true
        ]);
        ContableLicenciaIncapacidad::create([
            'concepto' => 'Licencia remunerada',
            'cuenta_contable' => '0506',
            'estado' => true
        ]);
        ContableLicenciaIncapacidad::create([
            'concepto' => 'Licencia no remunerada',
            'cuenta_contable' => '0506',
            'estado' => true
        ]);
        ContableLicenciaIncapacidad::create([
            'concepto' => 'Suspensión',
            'cuenta_contable' => '0506',
            'estado' => true
        ]);
        ContableLicenciaIncapacidad::create([
            'concepto' => 'Vacaciones',
            'cuenta_contable' => '0539',
            'estado' => true
        ]);
    }
}
