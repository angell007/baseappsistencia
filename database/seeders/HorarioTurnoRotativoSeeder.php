<?php

namespace Database\Seeders;

use App\Models\HorarioTurnoRotativo;
use Illuminate\Database\Seeder;

class HorarioTurnoRotativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HorarioTurnoRotativo::create([
            'funcionario_id' => 1,
            'turno_rotativo_id' => 1,
            'fecha' => date("Y-m-d H:m:s"),
            'numero_semana' => 10
        ]);
    }
}
