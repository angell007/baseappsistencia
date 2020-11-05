<?php

namespace Database\Seeders;

use App\Models\ContableDeduccion;
use Illuminate\Database\Seeder;
// use App\ContableDeduccion;

class ContableDeduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContableDeduccion::create([
            'concepto' => 'Préstamo',
            'cuenta_contable' => '425050',
            'estado' => true,
            'editable' => false
        ]);
        ContableDeduccion::create([
            'concepto' => 'Celular',
            'cuenta_contable' => '425050',
            'estado' => true,
            'editable' => false
        ]);
        ContableDeduccion::create([
            'concepto' => 'Otras deducciones',
            'cuenta_contable' => '425050',
            'estado' => true,
            'editable' => false
        ]);
        ContableDeduccion::create([
            'concepto' => 'Crédito libranza',
            'cuenta_contable' => '237030',
            'estado' => true,
            'editable' => false
        ]);
        ContableDeduccion::create([
            'concepto' => 'Aportes voluntarios a pensión',
            'cuenta_contable' => '238030',
            'estado' => true,
            'editable' => false
        ]);
    }
}
