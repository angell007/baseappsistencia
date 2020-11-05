<?php

namespace Database\Seeders;

use App\Models\Mes;
use Illuminate\Database\Seeder;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Mes::create([
            'Mes' => '2020-07-01',
            'Valor' => 5210,
        ]);
        Mes::create([
            'Mes' => '2020-06-01',
            'Valor' => 5156,
        ]);
        Mes::create([
            'Mes' => '2020-05-01',
            'Valor' => 5210,
        ]);
        Mes::create([
            'Mes' => '2020-03-01',
            'Valor' => 5232,
        ]);
        Mes::create([
            'Mes' => '2019-11-01',
            'Valor' => 5309,
        ]);
    }
}
