<?php

namespace Database\Seeders;

use App\Models\Cargo;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cargo::create([
            'nombre' => 'Coordinador de Talento Humano',
            'dependencia_id' => '1',
        ]);
        Cargo::create([
            'nombre' => 'Operario Nivel Uno',
            'dependencia_id' => '1',
        ]);
    }
}
