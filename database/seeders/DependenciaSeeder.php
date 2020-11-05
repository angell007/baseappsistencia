<?php

namespace Database\Seeders;

use App\Models\Dependencia;
use Illuminate\Database\Seeder;

class DependenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dependencia::create([
            'nombre' => 'Talento Humano',
            'centro_costo_id' => 1,
        ]);
        Dependencia::create([
            'nombre' => 'Mantenimiento',
            'centro_costo_id' => 1,
        ]);
    }
}
