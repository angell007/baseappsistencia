<?php

namespace Database\Seeders;

use App\Models\Cesantia;
use Illuminate\Database\Seeder;
// use App\Cesantia;

class CesantiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cesantia::create([
            'nombre' => 'Colfondos',
            'nit' => '800227940',
            'editable' => false

        ]);
        Cesantia::create([
            'nombre' => 'Colpensiones',
            'nit' => '900336004',
            'editable' => false

        ]);

        Cesantia::create([
            'nombre' => 'Protección',
            'nit' => '800229739',
            'editable' => false

        ]);
        Cesantia::create([
            'nombre' => 'Porvenir',
            'nit' => '800224808',
            'editable' => false

        ]);
        Cesantia::create([
            'nombre' => 'Old Mutual',
            'nit' => '800253055',
            'editable' => false

        ]);

        Cesantia::create([
            'nombre' => 'Fondo Nacional del Ahorro',
            'nit' => '899999284',
            'editable' => false

        ]);
    }
}
