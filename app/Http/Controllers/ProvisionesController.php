<?php

namespace App\Http\Controllers;

use App\Models\PagoProvisionesNominaFuncionario;
use Illuminate\Support\Facades\DB;
use App\Models\PagoNomina;
use Carbon\Carbon;

class ProvisionesController extends Controller
{
    public function getProvisiones($mes = null)
    {
        $provisiones = PagoProvisionesNominaFuncionario::all();

        //Si no existe en DB provisiones
        if ($provisiones->isEmpty()) {
            return [];
        }
        //Si no viene el mes por parámetro, el mes pasa a ser el del último pago registrado, esto normalmente pasa cuando aún no se ha registrado el pago de nómina en un periodo concreto
        $ultimoPago = PagoNomina::orderBy('created_at')->first();
        if (!$mes) {
            if (Carbon::parse($ultimoPago->inicio_periodo)->month === Carbon::parse($ultimoPago->fin_periodo)->month) {
                $mes = Carbon::parse($ultimoPago->inicio_periodo)->month;
            }
        }

        return PagoProvisionesNominaFuncionario::select('pago_nomina_id', DB::raw('SUM(cesantias) as cesantias'), DB::raw('SUM(intereses_cesantias) as intereses_cesantias'), DB::raw('SUM(prima) as prima'), DB::raw('SUM(vacaciones) as vacaciones'), DB::raw('SUM(total_provisiones) as total_provisiones'))->whereHas('pagoNomina', function ($query) use ($mes) {
            $query->whereMonth('inicio_periodo', $mes)->whereMonth('fin_periodo', $mes);
        })->groupBy('pago_nomina_id')->first();
    }

    public function getTotalProvisiones()
    {
        return PagoProvisionesNominaFuncionario::select(DB::raw('SUM(cesantias) as censantias'), DB::raw('SUM(intereses_cesantias) as intereses_cesantias'), DB::raw('SUM(prima) as prima'), DB::raw('SUM(vacaciones) as vacaciones'), DB::raw('SUM(total_provisiones) as total_provisiones'))->get();
    }

    /**
     * Obtener los meses en los que se hayan guardado provisiones, es decir, se haya pagado nómina
     *
     * @return void
     */
    public function getMesesProvisiones()
    {

        $pagosNomina = PagoNomina::all();

        $meses = collect([]);

        $pagosNomina->each(function ($pago) use (&$meses) {
            if (Carbon::parse($pago->inicio_periodo)->month === Carbon::parse($pago->fin_periodo)->month) {
                $meses[] =  Carbon::parse($pago->inicio_periodo)->month;
            }
        });

        return $meses;
    }
}
