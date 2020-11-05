<?php

namespace Database\Seeders;


use App\Models\ContableSalarioSubsidioTransporte;
use Illuminate\Database\Seeder;

class ContableSalarioSubsidioTransporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContableSalarioSubsidioTransporte::create([
            'concepto' => 'Salario',
            'cuenta_contable' => '0506',
            'contrapartida' => '2505',
            'estado' => true
        ]);

        ContableSalarioSubsidioTransporte::create([
            'concepto' => 'Salario integral',
            'cuenta_contable' => '0503',
            'contrapartida' => '2505',
            'estado' => true
        ]);

        ContableSalarioSubsidioTransporte::create([
            'concepto' => 'Honorarios',
            'cuenta_contable' => '1095',
            'contrapartida' => '233525',
            'estado' => true
        ]);

        ContableSalarioSubsidioTransporte::create([
            'concepto' => 'Cuota de sostenimiento',
            'cuenta_contable' => '0506',
            'contrapartida' => '2505',
            'estado' => true
        ]);

        ContableSalarioSubsidioTransporte::create([
            'concepto' => 'Subsidio de Transporte',
            'cuenta_contable' => '0527',
            'estado' => true
        ]);
    }
}
