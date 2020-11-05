<?php

namespace Database\Seeders;


use App\Models\TipoContrato;
use Illuminate\Database\Seeder;

class TipoContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoContrato::create([
            'nombre' => 'Término fijo',
            'editable' => false
        ]);
        TipoContrato::create([
            'nombre' => 'Término indefinido',
            'editable' => false
        ]);
        TipoContrato::create([
            'nombre' => 'Prestación de servicios',
            'editable' => false
        ]);
        TipoContrato::create([
            'nombre' => 'Pensionado término fijo',
            'editable' => false
        ]);
        TipoContrato::create([
            'nombre' => 'Pensionado término indefinido',
            'editable' => false
        ]);
        TipoContrato::create([
            'nombre' => 'Sena etapa lectiva',
            'editable' => false
        ]);
        TipoContrato::create([
            'nombre' => 'Sena etapa productiva',
            'editable' => false
        ]);
        TipoContrato::create([
            'nombre' => 'Estudiante universitario',
            'editable' => false
        ]);
        TipoContrato::create([
            'nombre' => 'Estudiante - Ley 789 de 2002',
            'editable' => false
        ]);
        TipoContrato::create([
            'nombre' => 'Estudiante pasantía - Decreto 055 de 2015',
            'editable' => false
        ]);
    }
}
