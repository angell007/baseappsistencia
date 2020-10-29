<?php

namespace App\Http\Controllers;

use App\Models\HorarioTurnoFijo;

class HorarioTurnosFijosController extends Controller
{
    public function getDatos($turno)
    {
        return HorarioTurnoFijo::where('turno_fijo_id', '=', $turno)->orderBy('id')->get();
    }


    public function store()
    {
        $atributos = request()->validate([
            'dia' => 'required',
            'turno_fijo_id' => 'required',
            'hora_inicio_uno' => 'required',
            'hora_fin_uno' => 'required',
            'hora_inicio_dos' => '',
            'hora_fin_dos' => '',
            'jornada_turno' => ''
        ]);

        HorarioTurnoFijo::create($atributos);

        return response()->json(['message' => 'Horario asignado correctamente']);
    }

    public function update($id)
    {
        $horario = HorarioTurnoFijo::find($id);

        if (!$horario) {
            return response()->json(['message' => 'Horario no encontrado'], 404);
        }

        $atributos = request()->validate([
            'dia' => 'required',
            'turno_fijo_id' => 'required',
            'hora_inicio_uno' => 'required',
            'hora_fin_uno' => 'required',
            'hora_inicio_dos' => '',
            'hora_fin_dos' => '',
            'jornada_turno' => ''
        ]);

        $horario->update($atributos);

        return response()->json(['message' => 'Horario asignado correctamente']);
    }
}
