<?php

namespace Database\Seeders;

use App\Models\ContableLiquidacion;
use Illuminate\Database\Seeder;

class ContableLiquidacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContableLiquidacion::create([
            'concepto' => 'Indemnización por retiro',
            'cuenta_contable' => '0560',
            'estado' => true
        ]);
        ContableLiquidacion::create([
            'concepto' => 'Otros ingresos liquidación',
            'cuenta_contable' => '0548',
            'estado' => true
        ]);
    }
}
