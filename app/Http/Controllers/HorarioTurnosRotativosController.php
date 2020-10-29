<?php

namespace App\Http\Controllers;

use App\Models\CentroCosto;
use App\Models\HorarioTurnoRotativo;

class HorarioTurnosRotativosController extends Controller
{
    /**
     * Retornar los centros de costos con las dependencias y con los funcionarios de cada dependencia que tengan turno rotativo 
     *
     * @return Response Json
     */
    public function getDatosGenerales($semana)
    {
        return CentroCosto::whereHas('dependencias.funcionarios', function ($query) {
            $query->where('tipo_turno', 'Rotativo');
        })->with(['dependencias' => function ($query) {
            $query->whereHas('funcionarios', function ($query) {
                $query->where('tipo_turno', 'Rotativo');
            })->with(['funcionarios' => function ($query) {
                $query->select('id', 'dependencia_id', 'nombres', 'apellidos', 'image')->where('tipo_turno', 'Rotativo')->with('horariosTurnoRotativo');
            }]);
        }])->get();
    }

    public function getDatos()
    {
        //    return Funcionario::with(['horarios' => function ($query) {
        //         return $query->orderBy('fecha');
        //     }])->get(['id']);

        return HorarioTurnoRotativo::all()->groupBy('funcionario_id');
    }

    public function store()
    {
        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'turno_rotativo_id' => 'required',
            'fecha' => 'required',
            'numero_semana' => 'required',
        ]);

        $fecha = $atributos['fecha'];
        $funcionarioId = $atributos['funcionario_id'];

        $horarioExistente = HorarioTurnoRotativo::where('fecha', $fecha)->where('funcionario_id', $funcionarioId)->first();

        if ($horarioExistente) {

            $horarioExistente->update($atributos);
            return response()->json(['message' => 'Horario actualizado correctamente']);
        }

        HorarioTurnoRotativo::create($atributos);

        return response()->json(['message' => 'Horario Asignado correctamente']);
    }

    public function update($id)
    {
        $horario = HorarioTurnoRotativo::findOrFail($id);

        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'turno_id' => 'required',
            'fecha' => 'required',
            'numero_semana' => 'required',
        ]);

        $horario->update($atributos);

        return response()->json(['message' => 'Horario actualizado correctamente']);
    }
}
