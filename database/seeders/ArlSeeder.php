<?php

namespace Database\Seeders;

use App\Models\Arl;
use Illuminate\Database\Seeder;

class ArlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Arl::create([
            'nombre' => 'Colpatria ARP',
            'nit' => '860002183',
            'editable' => false
        ]);
        Arl::create([
            'nombre' => 'Seguros Bolívar',
            'nit' => '860002503',
            'editable' => false
        ]);
        Arl::create([
            'nombre' => 'Seguros de Vida Aurora',
            'nit' => '860022137',
            'editable' => false
        ]);
        Arl::create([
            'nombre' => 'Alfa',
            'nit' => '860503617',
            'editable' => false
        ]);
        Arl::create([
            'nombre' => 'Liberty',
            'nit' => '860008645',
            'editable' => false
        ]);
        Arl::create([
            'nombre' => 'Positiva Compañía de Seguros',
            'nit' => '860011153',
            'editable' => false
        ]);
        Arl::create([
            'nombre' => 'Colmena',
            'nit' => '800226175',
            'editable' => false
        ]);
        Arl::create([
            'nombre' => 'ARP Sura',
            'nit' => '800256161',
            'editable' => false
        ]);
        Arl::create([
            'nombre' => 'La Equidad Seguros',
            'nit' => '830008686',
            'editable' => false
        ]);
        Arl::create([
            'nombre' => 'Mapfre Colombia Vida Seguros S.A.',
            'nit' => '830054904',
            'editable' => false
        ]);
    }
}
