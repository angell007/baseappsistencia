<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use App\Models\Funcionario;
use Illuminate\Support\Facades\DB;
use App\Models\CentroCosto;

class IndicadoresController extends Controller
{
    public function getNovedadesByCentros($fechaInicio, $fechaFin)
    {
        $totalNovedades = collect([
            'total' =>  Novedad::all()->count()
        ]);

        return CentroCosto::from('centro_costo as cc')->join('dependencia as dp', 'cc.id', 'dp.centro_costo_id')->join('funcionario as func', 'dp.id', 'func.dependencia_id')->join('novedad as nov', 'nov.funcionario_id', 'func.id')->select(DB::raw('distinct cc.nombre'), DB::raw('count(nov.id) as novedades'))->where('fecha_inicio', '>=', $fechaInicio)->where('fecha_fin', '<=', $fechaFin)->groupBy('cc.id')->orderBy('novedades', 'desc')->get();
    }

    public function getTopfuncionarios($fechaInicio, $fechaFin)
    {
        return Funcionario::from('funcionario as func')->join('novedad as nov', 'nov.funcionario_id', 'func.id')->select('func.id', 'func.nombres', 'func.apellidos', 'func.image', 'func.dependencia_id', DB::raw('count(nov.id) as novedades'))->where('nov.fecha_inicio', '>=', $fechaInicio)->where('nov.fecha_fin', '<=', $fechaFin)->groupBy('func.id')->orderBy('novedades', 'desc')->take(5)->with(['dependencia' => function ($query) {
            $query->select('id', 'nombre', 'centro_costo_id')->with('centroCosto:id,nombre');
        }])->get();
    }

    public function getNovedadesByDependencias($fechaInicio, $fechaFin)
    {

        return CentroCosto::from('centro_costo as cc')->join('dependencia as dp', 'dp.centro_costo_id', 'cc.id')->join('funcionario as func', 'dp.id', 'func.dependencia_id')->join('novedad as nov', 'nov.funcionario_id', 'func.id')->select(DB::raw('distinct dp.nombre as nombre'), 'cc.nombre as centro', DB::raw('count(nov.id) as novedades'))->where('fecha_inicio', '>=', $fechaInicio)->where('fecha_fin', '<=', $fechaFin)->groupBy('dp.id')->orderBy('novedades', 'desc')->get()->groupBy('centro');
    }

    public function getNovedadesByTipo($fechaInicio, $fechaFin)
    {
        return CentroCosto::from('centro_costo as cc')->join('dependencia as dp', 'dp.centro_costo_id', 'cc.id')->join('funcionario as func', 'dp.id', 'func.dependencia_id')->join('novedad as nov', 'nov.funcionario_id', 'func.id')->select(DB::raw('dp.nombre as dependencia'), 'nov.tipo as nombre', DB::raw('count(nov.id) as novedades'))->where('fecha_inicio', '>=', $fechaInicio)->where('fecha_fin', '<=', $fechaFin)->groupBy('dependencia', 'nombre')->orderBy('novedades', 'desc')->get()->groupBy('dependencia');
    }

    public function getLlegadasTardeByCentros($fechaInicio, $fechaFin)
    {
        return CentroCosto::from('centro_costo as cc')->join('dependencia as dp', 'cc.id', 'dp.centro_costo_id')->join('funcionario as func', 'dp.id', 'func.dependencia_id')->join('llegada_tarde as llt', 'llt.funcionario_id', 'func.id')->select(Db::raw('distinct cc.nombre'), DB::raw('count(llt.id) as llegadas'))->whereBetween('fecha', [$fechaInicio, $fechaFin])->groupBy('cc.id')->orderBy('llegadas', 'desc')->get();
    }

    public function getTopFuncionariosByLlegadas($fechaInicio, $fechaFin)
    {
        return Funcionario::from('funcionario as func')->join('llegada_tarde as llt', 'llt.funcionario_id', 'func.id')->select('func.id', 'func.nombres', 'func.apellidos', 'func.image', 'func.dependencia_id', DB::raw('count(llt.id) as llegadas'))->whereBetween('llt.fecha', [$fechaInicio, $fechaFin])->groupBy('func.id')->orderBy('llegadas', 'desc')->take(5)->with(['dependencia' => function ($query) {
            $query->select('id', 'nombre', 'centro_costo_id')->with('centroCosto:id,nombre');
        }])->get();
    }
    public function getTopFuncionariosByTiempo($fechaInicio, $fechaFin)
    {

        return Funcionario::from('funcionario as func')->join('llegada_tarde as llt', 'llt.funcionario_id', 'func.id')->select('func.id', 'func.nombres', 'func.apellidos', 'func.image', 'func.dependencia_id', DB::raw('sum((time_to_sec(llt.entrada_real) - time_to_sec(entrada_turno))/60) as tiempo_acumulado'))->whereBetween('llt.fecha', [$fechaInicio, $fechaFin])->groupBy('func.id')->orderBy('tiempo_acumulado', 'desc')->take(5)->with(['dependencia' => function ($query) {
            $query->select('id', 'nombre', 'centro_costo_id')->with('centroCosto:id,nombre');
        }])->get();
    }

    public function getLlegadasByDependencias($fechaInicio, $fechaFin)
    {

        return CentroCosto::from('centro_costo as cc')->join('dependencia as dp', 'dp.centro_costo_id', 'cc.id')->join('funcionario as func', 'dp.id', 'func.dependencia_id')->join('llegada_tarde as llt', 'llt.funcionario_id', 'func.id')->select(DB::raw('distinct dp.nombre as nombre'), 'cc.nombre as centro', DB::raw('count(llt.id) as llegadas'))->whereBetween('fecha', [$fechaInicio, $fechaFin])->groupBy('dp.id')->orderBy('llegadas', 'desc')->get()->groupBy('centro');
    }
}
