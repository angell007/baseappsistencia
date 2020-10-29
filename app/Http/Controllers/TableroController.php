<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Funcionario;
use App\Models\LlegadaTarde;
use App\Models\Novedad;
use Illuminate\Support\Facades\DB;

class TableroController extends Controller
{
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct()
    {
        DB::statement("SET lc_time_names = 'es_ES'");
        $this->fechaInicio = Carbon::now()->startOfMonth()->toDateString();
        $this->fechaFin = Carbon::now()->endOfMonth()->toDateString();
    }
    /**
     * Obtener los funcionarios con más llegadas tarde en el mes actual
     *
     * @return void
     */
    public function getTopFuncionariosByLlegadas()
    {
        return Funcionario::from('funcionario as func')->join('llegada_tarde as llt', 'llt.funcionario_id', 'func.id')->select('func.id', 'func.nombres', 'func.apellidos', 'func.image', 'func.dependencia_id', DB::raw('count(llt.id) as llegadas'))->whereBetween('llt.fecha', [$this->fechaInicio, $this->fechaFin])->groupBy('func.id')->orderBy('llegadas', 'desc')->take(5)->with('dependencia:id,nombre')->get();
    }

    public function getLlegadasByFecha()
    {
        return LlegadaTarde::whereBetween('fecha', [$this->fechaInicio, $this->fechaFin])->orderBy('fecha')->get(['id', 'fecha', 'tiempo'])->groupBy('fecha');
    }

    public function getBirthdayFuncionarios()
    {

        return Funcionario::select('nombres', 'apellidos', DB::raw(
            'DATE_FORMAT(fecha_nacimiento,"%d %M") as fecha'
        ), 'image', DB::raw(
            'Year(CURDATE()) - Year(fecha_nacimiento) as anios'
        ))->whereRaw('DATE_FORMAT(fecha_nacimiento,"%m-%d") >= DATE_FORMAT(NOW(),"%m-%d")')->orderByRaw('Month(fecha_nacimiento) ASC, DAY(fecha_nacimiento) ASC')->take(5)->get();
    }

    public function getVencimientoContratos()
    {
        return Funcionario::select('id', 'nombres', 'apellidos', 'image', DB::raw('DATE_FORMAT(fecha_retiro,"%d %M") as fecha_retiro'), 'tipo_contrato_id', DB::raw('DATEDIFF(fecha_retiro,CURDATE()) as dias_restantes'))->whereNotNull('fecha_retiro')->whereRaw('fecha_retiro >= CURDATE()')->whereHas('contrato', function ($query) {
            $query->where('id', '=', 1);
        })->with('contrato')->orderBy('fecha_retiro')->take(5)->get();
    }

    public function getIndicadores(){
        $llegadas = LlegadaTarde::whereBetween('fecha', [$this->fechaInicio, $this->fechaFin])->orderBy('fecha')->get(['id']);
        $novedades = Novedad::whereBetween('fecha_inicio', [$this->fechaInicio, $this->fechaFin])->orderBy('fecha_inicio')->get(['id']);
        $nuevos = Funcionario::whereBetween('fecha_ingreso', [$this->fechaInicio, $this->fechaFin])->orderBy('fecha_ingreso')->get(['id']);
        $datos = array(
            'Llegadas' => count($llegadas),
            'Novedades' => count($novedades),
            'Renuncias' => 0,
            'Nuevos' => count($nuevos)
        );
        return $datos;
    }
}
