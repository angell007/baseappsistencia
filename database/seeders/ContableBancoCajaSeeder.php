<?php

namespace Database\Seeders;

use App\Models\ContableBancoCaja;
use Illuminate\Database\Seeder;
// use App\ContableBancoCaja;

class ContableBancoCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContableBancoCaja::create([
            'concepto' => 'Bancos',
            'cuenta_contable' => '1110',
            'estado' => true
        ]);
        ContableBancoCaja::create([
            'concepto' => 'Caja',
            'cuenta_contable' => '1105',
            'estado' => true
        ]);
    }
}
