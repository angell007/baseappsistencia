<?php

namespace Database\Seeders;

use App\Models\ContableSeguridadSocial;
use Illuminate\Database\Seeder;

class ContableSeguridadSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContableSeguridadSocial::create([
            'concepto' => 'Salud',
            'cuenta_contable' => '0569',
            'contrapartida' => '237005',
            'estado' => true,
            'editable' => true
        ]);
        ContableSeguridadSocial::create([
            'concepto' => 'Pensión',
            'cuenta_contable' => '0570',
            'contrapartida' => '238030',
            'estado' => true,
            'editable' => true
        ]);
        ContableSeguridadSocial::create([
            'concepto' => 'SENA',
            'cuenta_contable' => '0578',
            'contrapartida' => '237010',
            'estado' => true,
            'editable' => true
        ]);
        ContableSeguridadSocial::create([
            'concepto' => 'ICBF',
            'cuenta_contable' => '0575',
            'contrapartida' => '237010',
            'estado' => true,
            'editable' => true
        ]);
        ContableSeguridadSocial::create([
            'concepto' => 'Caja de compensación',
            'cuenta_contable' => '0572',
            'contrapartida' => '237010',
            'estado' => true,
            'editable' => true
        ]);
        ContableSeguridadSocial::create([
            'concepto' => 'ARL - Riesgo 1',
            'cuenta_contable' => '0568',
            'contrapartida' => '237006',
            'estado' => true,
            'editable' => true
        ]);
        ContableSeguridadSocial::create([
            'concepto' => 'ARL - Riesgo 2',
            'cuenta_contable' => '0568',
            'contrapartida' => '237006',
            'estado' => true,
            'editable' => true
        ]);
        ContableSeguridadSocial::create([
            'concepto' => 'ARL - Riesgo 3',
            'cuenta_contable' => '0568',
            'contrapartida' => '237006',
            'estado' => true,
            'editable' => true
        ]);
        ContableSeguridadSocial::create([
            'concepto' => 'ARL - Riesgo 4',
            'cuenta_contable' => '0568',
            'contrapartida' => '237006',
            'estado' => true,
            'editable' => true
        ]);
        ContableSeguridadSocial::create([
            'concepto' => 'ARL - Riesgo 5',
            'cuenta_contable' => '0568',
            'contrapartida' => '237006',
            'estado' => true,
            'editable' => true
        ]);
    }
}
