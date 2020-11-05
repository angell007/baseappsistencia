<?php

namespace Database\Seeders;


use App\Models\ContableIngreso;
use Illuminate\Database\Seeder;

class ContableIngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Constitutivos */
        ContableIngreso::create([
            'concepto' => 'Comisiones',
            'tipo' => 'Constitutivo',
            'cuenta_contable' => '0518',
            'estado' => true,
            'editable' => false

        ]);
        ContableIngreso::create([
            'concepto' => 'Bonificación prestacional',
            'tipo' => 'Constitutivo',
            'cuenta_contable' => '0548',
            'estado' => true,
            'editable' => false

        ]);
        ContableIngreso::create([
            'concepto' => 'Otros ingresos',
            'tipo' => 'Constitutivo',
            'cuenta_contable' => '0548',
            'estado' => true,
            'editable' => false
        ]);

        /** No Constitutivos */
        ContableIngreso::create([
            'concepto' => 'Auxilio de movilización',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '0595',
            'estado' => true,
            'editable' => false
        ]);
        ContableIngreso::create([
            'concepto' => 'Honorarios',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '1095',
            'estado' => true,
            'editable' => false
        ]);
        ContableIngreso::create([
            'concepto' => 'Otros ingresos no prestacionales	',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '0548',
            'estado' => true,
            'editable' => false
        ]);
        ContableIngreso::create([
            'concepto' => 'Auxilio de Alimentación',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '0545',
            'estado' => true,
            'editable' => false
        ]);
        ContableIngreso::create([
            'concepto' => 'Bonificación no prestacional',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '0548',
            'estado' => true,
            'editable' => false
        ]);
        ContableIngreso::create([
            'concepto' => 'Bonificación extralegal por desempeño',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '0548',
            'estado' => true,
            'editable' => false

        ]);
        ContableIngreso::create([
            'concepto' => 'Bono canasta',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '0595',
            'estado' => true,
            'editable' => false
        ]);

        ContableIngreso::create([
            'concepto' => 'Bonificación a mera liberalidad',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '05',
            'estado' => true,
            'editable' => false
        ]);
        ContableIngreso::create([
            'concepto' => 'Auxilio de Salud',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '0545',
            'estado' => true,
            'editable' => false
        ]);

        ContableIngreso::create([
            'concepto' => 'Auxilio de Estudio',
            'tipo' => 'No Constitutivo',
            'cuenta_contable' => '0545',
            'estado' => true,
            'editable' => false
        ]);
    }
}
