<?php

namespace Database\Seeders;


use App\Models\Pension;
use Illuminate\Database\Seeder;

class PensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pension::create([
            'nombre' => 'Protección',
            'nit' => '800229739',
            'editable' => false,

        ]);
        Pension::create([
            'nombre' => 'Porvenir',
            'nit' => '800224808',
            'editable' => false

        ]);
        Pension::create([
            'nombre' => 'Old Mutual',
            'nit' => '800253055',
            'editable' => false

        ]);
        Pension::create([
            'nombre' => 'Old Mutual Alternativo',
            'nit' => '830125132',
            'editable' => false

        ]);
        Pension::create([
            'nombre' => 'Colfondos',
            'nit' => '800227940',
            'editable' => false

        ]);
        Pension::create([
            'nombre' => 'Caxdac',
            'nit' => '860007379',
            'editable' => false

        ]);
        Pension::create([
            'nombre' => 'Fonprecon',
            'nit' => '899999734',
            'editable' => false

        ]);
        Pension::create([
            'nombre' => 'Pensiones de Antioquia',
            'nit' => '800216278',
            'editable' => false

        ]);
        Pension::create([
            'nombre' => 'Colpensiones',
            'nit' => '900336004',
            'editable' => false

        ]);
    }
}
