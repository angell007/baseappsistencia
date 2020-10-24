<?php

use Illuminate\Database\Seeder;
use App\ContableLiquidacion;

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
