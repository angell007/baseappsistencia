<?php
namespace App\Http\Controllers;

use App\Models\CentroCosto;
use Illuminate\Support\Facades\DB;

class ReporteHorariosController extends Controller
{
    /**
     * Reporte Horarios turnos rotativos
     *
     * @param string $fechaInicio
     * @param string $fechafin
     * @return Response
     */
    public function getDatosTurnoRotativo($fechaInicio, $fechafin)
    {
        $filtroFecha = function ($query) use ($fechaInicio, $fechafin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechafin]);
        };

        return CentroCosto::whereHas('dependencias.funcionarios.diariosTurnoRotativo', $filtroFecha)->with(['dependencias' =>
        function ($query) use ($filtroFecha, $fechaInicio, $fechafin) {
            $query->whereHas('funcionarios.diariosTurnoRotativo', $filtroFecha)->with(['funcionarios' =>
            function ($query) use ($filtroFecha, $fechaInicio, $fechafin) {
                $query->select('id', 'dependencia_id', 'nombres', 'apellidos', 'image', 'tipo_turno')->where('tipo_turno', 'Rotativo')->whereHas('diariosTurnoRotativo', $filtroFecha)->with(['diariosTurnoRotativo' =>
                function ($query) use ($fechaInicio, $fechafin) {
                    $query->select()->whereBetween('fecha', [$fechaInicio, $fechafin])->addSelect(
                        DB::raw('TIMESTAMPDIFF(SECOND,CONCAT(fecha," ",hora_entrada_uno),CONCAT(fecha_salida," ",hora_salida_uno))/3600 as cantidad_horas')
                    );
                }]);
            }]);
        }])->get(['id', 'nombre']);
    }

    /**
     * Reporte Horarios turnos fijos
     *
     * @param string $fechaInicio
     * @param string $fechafin
     * @return Response
     */
    public function getDatosTurnoFijo($fechaInicio, $fechafin)
    {
        $filtroFecha = function ($query) use ($fechaInicio, $fechafin) {
            $query->where('fecha', '>=', $fechaInicio)->where('fecha', '<=', $fechafin);
        };

        return CentroCosto::whereHas('dependencias.funcionarios.diariosTurnoFijo', $filtroFecha)->with(['dependencias' =>
        function ($query) use ($filtroFecha, $fechaInicio, $fechafin) {
            $query->whereHas('funcionarios.diariosTurnoFijo', $filtroFecha)->with(['funcionarios' =>
            function ($query) use ($filtroFecha, $fechaInicio, $fechafin) {
                $query->select('id', 'dependencia_id', 'nombres', 'apellidos', 'image', 'tipo_turno')->where('tipo_turno', 'Fijo')->whereHas('diariosTurnoFijo', $filtroFecha)->with(['diariosTurnoFijo' =>
                function ($query) use ($fechaInicio, $fechafin) {
                    $query->select()->whereBetween('fecha', [$fechaInicio, $fechafin])->addSelect(
                        DB::raw('(IF(FORMAT((TIME_TO_SEC(hora_salida_uno) - TIME_TO_SEC(hora_entrada_uno))/3600,2)>=0,FORMAT((TIME_TO_SEC(hora_salida_uno) - TIME_TO_SEC(hora_entrada_uno))/3600,2),0) +(IF(FORMAT((TIME_TO_SEC(hora_salida_dos) - TIME_TO_SEC(hora_entrada_dos))/3600,2)>=0,FORMAT((TIME_TO_SEC(hora_salida_dos) - TIME_TO_SEC(hora_entrada_dos))/3600,2),0))) as cantidad_horas')
                    );
                }]);
            }]);
        }])->get(['id', 'nombre']);
    }
}
