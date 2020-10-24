<?php

namespace App\Http\Controllers;

use App\ContableIngreso;
use App\Empresa;
use App\Funcionario;
use App\Novedad;
use App\Http\Libs\Nomina\Calculos\CalculoProvisiones;
use App\Http\Libs\Nomina\Calculos\ResumenPago;

use App\Http\Libs\Nomina\Facades\NominaExtras;
use App\Http\Libs\Nomina\Facades\NominaNovedades;
use App\Http\Libs\Nomina\Facades\NominaIngresos;
use App\Http\Libs\Nomina\Facades\NominaSalario;
use App\Http\Libs\Nomina\Facades\NominaRetenciones;
use App\Http\Libs\Nomina\Facades\NominaDeducciones;
use App\Http\Libs\Nomina\Facades\NominaSeguridad;
use App\Http\Libs\Nomina\Facades\NominaProvisiones;
use App\Http\Libs\Nomina\Facades\NominaPago;



use App\Deduccion;
use Carbon\Carbon;
use App\PagoNomina;
use PDF;


class PagosNominaController extends Controller
{

    public function getFuncionario($identidad)
    {
        $funcionario = Funcionario::where('identidad', '=', $identidad)->with('cargo')->first();
        if (!$funcionario) {
            return response()->json(['message' => 'Funcionario no encontrado'], 404);
        }

        return $funcionario;
    }
    /**
     * Calcular la cantidad y total de horas extras y recargos acumulados del funcionario en el periodo
     *
     * @param int $id
     * @param string $fechaInicio
     * @param string $fechaFin
     * @return Illuminate\Support\Collection
     */
    public function getExtrasTotales($id, $fechaInicio, $fechaFin)
    {
        return NominaExtras::extrasFuncionarioWithId($id)->fromTo($fechaInicio, $fechaFin);
    }
    /**
     * Calcular la cantidad y total de novedades del funcionario en el periodo
     *
     * @param int $id
     * @param string $fechaInicio
     * @param string $fechaFin
     * @return Illuminate\Support\Collection
     */
    public function getNovedades($id, $fechaInicio, $fechaFin)
    {
        return NominaNovedades::novedadesFuncionarioWithId($id)
            ->fromTo($fechaInicio, $fechaFin)
            ->calculate();
    }

    public function getIngresos($id, $fechaInicio, $fechaFin)
    {
        return NominaIngresos::ingresosFuncionarioWithId($id)
            ->fromTo($fechaInicio, $fechaFin)
            ->calculate();
    }

    public function getSalario($id, $fechaInicio, $fechaFin)
    {
        return NominaSalario::salarioFuncionarioWithId($id)
            ->fromTo($fechaInicio, $fechaFin)
            ->calculate();
    }

    public function getRetenciones($id, $fechaInicio, $fechaFin)
    {
        return NominaRetenciones::retencionesFuncionarioWithId($id)
            ->fromTo($fechaInicio, $fechaFin)
            ->calculate();
    }

    public function getDeducciones($id, $fechaInicio, $fechaFin)
    {
        return NominaDeducciones::deduccionesFuncionarioWithId($id)
            ->fromTo($fechaInicio, $fechaFin)
            ->calculate();
    }

    public function getSeguridad($id, $fechaInicio, $fechaFin)
    {
        return NominaSeguridad::seguridadFuncionarioWithId($id)
            ->fromTo($fechaInicio, $fechaFin)
            ->calculate();
    }

    public function getProvisiones($id, $fechaInicio, $fechaFin)
    {
        return NominaProvisiones::provisionesFuncionarioWithId($id)
            ->fromTo($fechaInicio, $fechaFin)
            ->calculate();
    }


    public function getPagoNeto($id, $fechaInicio, $fechaFin)
    {
        return NominaPago::pagoFuncionarioWithId($id)
            ->fromTo($fechaInicio, $fechaFin)
            ->calculate();
    }


    public function getIngresosPrestacionales()
    {
        return ContableIngreso::where('tipo', '=', 'Constitutivo')->get();
    }

    public function getIngresosNoPrestacionales()
    {
        return ContableIngreso::where('tipo', '=', 'No Constitutivo')->get();
    }


    public function getPagoFuncionarios($inicio = null, $fin = null)
    {
        $frecuenciaPago =  Empresa::get(['frecuencia_pago'])->first()['frecuencia_pago'];
        $fechaInicioPeriodo = Carbon::now()->startOfMonth();
        $fechaFinPeriodo = Carbon::now()->endOfMonth();
        $funcionariosResponse = [];

        if ($frecuenciaPago === 'Quincenal') {
            if (Carbon::now() > Carbon::now()->startOfMonth()->addDays(14)) {

                $fechaInicioPeriodo = $fechaInicioPeriodo->addDays(15);
            } else {
                $fechaFinPeriodo = $fechaFinPeriodo->subDays(15);
            }
        }

        $fechaInicioPeriodo = $fechaInicioPeriodo->toDateString();
        $fechaFinPeriodo = $fechaFinPeriodo->toDateString();

        /**
         * Comprobar si los parámetros inicio y fin no son nulos, si no lo son, entonces significa
         * que se requiere ver o actualizar una nómina antigua ya que estos valores solo son asignados
         * desde el componente de historial de pagos en Vue cuando se realiza una petición.
         */
        if ($inicio) {
            $fechaInicioPeriodo = $inicio;
        }

        if ($fin) {
            $fechaFinPeriodo = $fin;
        }

        $fechasNovedades = function ($query) use ($fechaInicioPeriodo, $fechaFinPeriodo) {
            return $query->whereBetween('fecha_inicio', [$fechaInicioPeriodo, $fechaFinPeriodo])->whereBetween('fecha_fin', [$fechaInicioPeriodo, $fechaFinPeriodo])->with('novedad');
        };

        $funcionarios = Funcionario::with(['novedades' => $fechasNovedades])->get();

        foreach ($funcionarios as $funcionario) {

            $funcionariosResponse[] = response()->json([
                'id' => $funcionario->id,
                'identidad' => $funcionario->identidad,
                'nombres' => $funcionario->nombres,
                'apellidos' => $funcionario->apellidos,
                'image' => $funcionario->image,
                'salario_neto' => $this->getPagoNeto($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['total_valor_neto'],
                'novedades' => $funcionario->novedades,
                'horas_extras' => $this->getExtrasTotales($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['horas_reportadas'],
                'novedades' => $this->getNovedades($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['novedades']
            ]);
        }

        return $funcionariosResponse;
    }

    /**
     * Retorna el resumen del pago de nómina en el mes actual, si ya existe en la BD entonces se modifica la  respuesta agregando propiedades a la respuesta
     *
     * @return Json
     */
    public function getPagoNomina($inicio = null, $fin = null)
    {
        $frecuenciaPago =  Empresa::get(['frecuencia_pago'])->first()['frecuencia_pago'];
        $pagoNomina = $nomina = $paga = $idNominaExistente = null;

        $fechaInicioPeriodo = Carbon::now()->startOfMonth();
        $fechaFinPeriodo = Carbon::now()->endOfMonth();

        $totalSalarios = 0;
        $totalRetenciones = 0;
        $totalSeguridadSocial = 0;
        $totalParafiscales = 0;
        $totalProvisiones = 0;
        $totalExtras = 0;
        $totalIngresos = 0;
        $totalCostoEmpresa = 0;

        if ($frecuenciaPago === 'Quincenal') {
            if (Carbon::now() > Carbon::now()->startOfMonth()->addDays(14)) {

                $fechaInicioPeriodo = $fechaInicioPeriodo->addDays(15);
            } else {
                $fechaFinPeriodo = $fechaFinPeriodo->subDays(15);
            }
        }

        $fechaInicioPeriodo = $fechaInicioPeriodo->toDateString();
        $fechaFinPeriodo = $fechaFinPeriodo->toDateString();

        /**
         * Comprobar si los parámetros inicio y fin no son nulos, si no lo son, entonces significa
         * que se requiere ver o actualizar una nómina antigua ya que estos valores solo son asignados
         * desde el componente de historial de pagos en Vue cuando se realiza una petición.
         */
        if ($inicio) {
            $fechaInicioPeriodo = $inicio;
        }

        if ($fin) {
            $fechaFinPeriodo = $fin;
        }

        /**
         * Comprobar si ya existe un pago de nómina en el periodo
         */

        $nomina = PagoNomina::where('inicio_periodo', $fechaInicioPeriodo)->where('fin_periodo', $fechaFinPeriodo)->first();

        if ($nomina) {
            $paga = true;
            $idNominaExistente = $nomina->id;
        }

        $funcionarios = Funcionario::with(['novedades' => function ($query) use ($fechaInicioPeriodo, $fechaFinPeriodo) {
            return $query->whereBetween('fecha_inicio', [$fechaInicioPeriodo, $fechaFinPeriodo])->whereBetween('fecha_fin', [$fechaInicioPeriodo, $fechaFinPeriodo])->with('novedad');
        }])->get();

        foreach ($funcionarios as $funcionario) {

            $totalSalarios +=  $this->getPagoNeto($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['total_valor_neto'];

            $totalRetenciones += $this->getRetenciones($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['valor_total'];

            $totalSeguridadSocial += $this->getSeguridad($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['valor_total_seguridad'];

            $totalParafiscales += $this->getSeguridad($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['valor_total_parafiscales'];

            $totalProvisiones += $this->getProvisiones($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['valor_total'];

            $totalExtras += $this->getExtrasTotales($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['valor_total'];

            $totalIngresos += $this->getIngresos($funcionario->id, $fechaInicioPeriodo, $fechaFinPeriodo)['valor_total'];
        }

        $totalCostoEmpresa += $totalSalarios + $totalRetenciones +   $totalSeguridadSocial + $totalParafiscales + $totalProvisiones;

        $pagoNomina = response()->json([
            'frecuencia_pago' => $frecuenciaPago,
            'inicio_periodo' => $fechaInicioPeriodo,
            'fin_periodo' => $fechaFinPeriodo,
            'salarios' =>  $totalSalarios,
            'seguridad_social' => $totalSeguridadSocial,
            'parafiscales' => $totalParafiscales,
            'provisiones' => $totalProvisiones,
            'extras' => $totalExtras,
            'ingresos' => $totalIngresos,
            'retenciones' => $totalRetenciones,
            'costo_total_empresa' => $totalCostoEmpresa,
            'nomina_paga' => $paga,
            'nomina_paga_id' => $idNominaExistente
        ]);

        return $pagoNomina;
    }

    /**
     * Obtener el desprendible o colilla de pago del funcionario
     *
     * @param int $id
     * @param string $fechaInicio
     * @param string $fechaFin
     * @return file
     */
    public function getColillaFuncionario($id, $fechaInicio, $fechaFin)
    {

        $funcionarioDB = Funcionario::with('cargo')->find($id);

        $empresa = Empresa::first();
        if (!$empresa) {
            $empresa = 'No Registrada';
        }
        $auxilioTransporte = $funcionarioDB->subsidio_transporte ? $empresa->auxilio_transporte : 0;

        $novedades = $this->getNovedades($id, $fechaInicio, $fechaFin);

        $funcionario = collect([
            'empresa' => $empresa->razon_social,
            'identidad' => $funcionarioDB->identidad,
            'nombres' => $funcionarioDB->nombres,
            'apellidos' => $funcionarioDB->apellidos,
            'cargo' => $funcionarioDB->cargo->nombre,
            'inicio' => Carbon::parse($fechaInicio)->format('d-m-Y'),
            'fin' => Carbon::parse($fechaFin)->format('d-m-Y'),
            'salario' => $funcionarioDB->salario,
            'auxilio_transporte' => $auxilioTransporte,
            'salario_neto' => $this->getPagoNeto($funcionarioDB->id, $fechaInicio, $fechaFin)['total_valor_neto'],
            'retenciones' => $this->getRetenciones($funcionarioDB->id, $fechaInicio, $fechaFin)['valor_total'],
            'horas_extras' => $this->getExtrasTotales($funcionarioDB->id, $fechaInicio, $fechaFin)['valor_total'],
        ]);

        // return view('nomina.colilla', compact('funcionario'));

        $nombrePdf = $funcionario['nombres'] . '_' . $funcionario['apellidos'] . '.pdf';
        return PDF::loadView('nomina.colilla', compact('funcionario'))->download($nombrePdf);
    }


    public function store()
    {
        $atributos = request()->validate([
            'admin_id' => 'required',
            'inicio_periodo' => 'required|string',
            'fin_periodo' => 'required|string',
            'total_salarios' => 'required|numeric',
            'total_retenciones' => 'required|numeric',
            'total_provisiones' => 'required|numeric',
            'total_seguridad_social' => 'required|numeric',
            'total_parafiscales' => 'required|numeric',
            'total_extras_recargos' => 'required|numeric',
            'total_ingresos' => 'required|numeric',
            'costo_total' => 'required|numeric'
        ]);

        $pagoNomina = PagoNomina::create($atributos);
        $funcionarios = Funcionario::where('liquidado', false)->get();


        $funcionarios->each(function ($funcionario) use ($pagoNomina) {
            $pagoNomina->pagosNominaFuncionario()->create([
                'funcionario_id' => $funcionario->id,
                'pago_nomina_id' => $pagoNomina->id,
                'dias_trabajados' => $this->getSalario($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['dias_trabajados'],
                'salario' => $this->getSalario($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['salario'],
                'auxilio_transporte' => $this->getSalario($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['auxilio_transporte'],
                'retenciones_deducciones' => $this->getRetenciones($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['valor_total'],
                'salario_neto' => $this->getPagoNeto($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['total_valor_neto'],
            ]);
        });

        $funcionarios->each(function ($funcionario) use ($pagoNomina) {
            $pagoNomina->pagosProvisionesNominaFuncionario()->create([
                'funcionario_id' => $funcionario->id,
                'pago_nomina_id' => $pagoNomina->id,
                'cesantias' => $this->getProvisiones($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['resumen']['cesantias']['valor'],
                'intereses_cesantias' => $this->getProvisiones($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['resumen']['intereses_cesantias']['valor'],
                'prima' => $this->getProvisiones($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['resumen']['prima']['valor'],
                'vacaciones' => $this->getProvisiones($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['resumen']['vacaciones']['valor'],
                'dias_acumulados_vacaciones' =>  $this->getProvisiones($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['dias_vacaciones']['vacaciones_acumuladas_periodo'],
                'total_provisiones' => $this->getProvisiones($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['valor_total']
            ]);
        });


        $funcionarios->each(function ($funcionario) use ($pagoNomina) {
            $pagoNomina->pagosSeguridadNominaFuncionario()->create([
                'funcionario_id' => $funcionario->id,

                'pago_nomina_id' => $pagoNomina->id,

                'salud' =>  $this->getSeguridad($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['seguridad_social']['Salud'],

                'pension' =>  $this->getSeguridad($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['seguridad_social']['Pensión'],

                'riesgos' =>  $this->getSeguridad($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['seguridad_social']['Riesgos'],

                'sena' => $this->getSeguridad($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['parafiscales']['Sena'],

                'icbf' => $this->getSeguridad($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['parafiscales']['Icbf'],

                'caja_compensacion' => $this->getSeguridad($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['parafiscales']['Caja de compensación'],

                'total_seguridad_social' => $this->getSeguridad($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['valor_total_seguridad'],

                'total_parafiscales' => $this->getSeguridad($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['valor_total_parafiscales'],

                'total_seguridad_social_parafiscales' => $this->getSeguridad($funcionario->id, $pagoNomina->inicio_periodo, $pagoNomina->fin_periodo)['valor_total'],
            ]);
        });

        return response()->json(['message' => 'Nómina guardada correctamente'], 200);
    }

    /**
     * Eliminar un Pago de nómina
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $nomina = PagoNomina::find($id);

        if (!$nomina) {
            return response()->json(['message' => 'Pago de nómina no encontrada'], 404);
        }

        $nomina->delete();

        return response()->json(['message' => 'Pago de nómina eliminada correctamente']);
    }
}
