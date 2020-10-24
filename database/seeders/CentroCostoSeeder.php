<?php

use Illuminate\Database\Seeder;
use App\CentroCosto;

class CentroCostoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CentroCosto::create([
            'nombre' => 'Administrativo',
            'codigo' => '01',
            'prefijo_cuenta_contable' => '51'
        ]);
        CentroCosto::create([
            'nombre' => 'Ventas',
            'codigo' => '02',
            'prefijo_cuenta_contable' => '52'
        ]);
        CentroCosto::create([
            'nombre' => 'Obras',
            'codigo' => '03',
            'prefijo_cuenta_contable' => '53'
        ]);
    }
}
