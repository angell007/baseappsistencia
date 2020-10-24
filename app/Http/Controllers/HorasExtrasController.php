<?php

namespace App\Http\Controllers;

use App\CentroCosto;
use App\ReporteExtras;

class HorasExtrasController extends Controller
{
    public function getDatosTurnoRotativo($fechaInicio, $fechaFin)
    {
        $filtroDiarioFecha = function ($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin])->orderBy('fecha')->with('turnoRotativo:id,nombre,hora_inicio_uno,hora_fin_uno,tolerancia_entrada,tolerancia_salida');;
        };

        return CentroCosto::whereHas('dependencias.funcionarios.diariosTurnoRotativo', $filtroDiarioFecha)->with(['dependencias' => function ($query) use ($filtroDiarioFecha) {
            $query->select('id', 'centro_costo_id', 'nombre')->whereHas('funcionarios.diariosTurnoRotativo', $filtroDiarioFecha)->with(['funcionarios' => function ($query) use ($filtroDiarioFecha) {
                $query->select('id', 'dependencia_id', 'nombres', 'apellidos', 'tipo_turno', 'image')->whereHas('diariosTurnoRotativo')->with(['diariosTurnoRotativo' => $filtroDiarioFecha]);
            }]);
        }])->get(['id', 'nombre']);
    }


    public function getDatosTurnoFijo($fechaInicio, $fechaFin)
    {
        $filtroDiarioFecha = function ($query) use ($fechaInicio, $fechaFin) {
            $query->select('id', 'funcionario_id', 'fecha', 'turno_fijo_id', 'hora_entrada_uno', 'hora_salida_uno', 'hora_entrada_dos', 'hora_salida_dos')->whereBetween('fecha', [$fechaInicio, $fechaFin])->orderBy('fecha')->with(['turnoFijo' => function ($query) {
                $query->select('id', 'nombre', 'tolerancia_entrada', 'tolerancia_salida')->with('horariosTurnoFijo:id,turno_fijo_id,dia,hora_inicio_uno,hora_fin_uno,hora_inicio_dos,hora_fin_dos');
            }]);
        };

        return CentroCosto::whereHas('dependencias.funcionarios.diariosTurnoFijo', $filtroDiarioFecha)->with(['dependencias' => function ($query) use ($filtroDiarioFecha) {
            $query->select('id', 'centro_costo_id', 'nombre')->whereHas('funcionarios.diariosTurnoFijo', $filtroDiarioFecha)->with(['funcionarios' => function ($query) use ($filtroDiarioFecha) {
                $query->select('id', 'dependencia_id', 'nombres', 'apellidos', 'tipo_turno', 'image')->whereHas('diariosTurnoFijo')->with(['diariosTurnoFijo' => $filtroDiarioFecha]);
            }]);
        }])->get(['id', 'nombre']);
    }

    public function store()
    {
        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'fecha' => 'required',
            'ht' => 'required',
            'hed' => 'required',
            'hen' => 'required',
            'hedfd' => 'required',
            'hedfn' => 'required',
            'rn' => 'required',
            'rf' => 'required',
            'hed_reales' => 'required',
            'hen_reales' => 'required',
            'hedfd_reales' => 'required',
            'hedfn_reales' => 'required',
            'rn_reales' => 'required',
            'rf_reales' => 'required',
        ]);

        ReporteExtras::create($atributos);

        return response()->json(['message' => 'Horas extras validadas correctamente']);
    }

    /**
     * Se retorna un único dato debido a que una extra solo puede estar validada una única vez, es decir no pueden existir dos o más validaciones de una hora extra con el mismo día
     *
     * @param string $fecha
     * @return ReporteExtras
     */
    public function getDatosValidados($funcionario, $fecha)
    {

        $validada = ReporteExtras::where('fecha', $fecha)->where('funcionario_id', $funcionario)->orderBy('fecha')->first();

        if ($validada) {
            return $validada;
        }
    }

    public function update($id)
    {
        $validada = ReporteExtras::findOrFail($id);

        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'fecha' => 'required',
            'ht' => 'required',
            'hed' => 'required',
            'hen' => 'required',
            'hedfd' => 'required',
            'hedfn' => 'required',
            'rn' => 'required',
            'rf' => 'required',
            'hed_reales' => 'required',
            'hen_reales' => 'required',
            'hedfd_reales' => 'required',
            'hedfn_reales' => 'required',
            'rn_reales' => 'required',
            'rf_reales' => 'required',
        ]);

        $validada->update($atributos);

        return response()->json(['Horas extras validadas y actualizadas correctamente']);
    }
}
