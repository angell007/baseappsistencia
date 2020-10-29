<?php

namespace App\Http\Controllers;

use App\Models\ContableSalarioSubsidioTransporte;
use App\Models\ContableIngreso;
use App\Models\ContableLicenciaIncapacidad;
use App\Models\ContableDeduccion;
use App\Models\ContablePrestacionSocial;
use App\Models\ContableSeguridadSocial;
use App\Models\ContableLiquidacion;
use App\Models\ContableBancoCaja;

class ParametrizacionController extends Controller
{
    public function salarioSubsidioDatos()
    {
        return ContableSalarioSubsidioTransporte::all();
    }

    public function ingresosConstitutivosDatos()
    {
        return ContableIngreso::ingreso('Constitutivo');
    }

    public function ingresosNoConstitutivosDatos()
    {
        return ContableIngreso::ingreso('No Constitutivo');
    }

    public function licenciasIncapacidadesDatos()
    {
        return ContableLicenciaIncapacidad::all();
    }

    public function deduccionesDatos()
    {
        return ContableDeduccion::where('estado', true)
            ->get(['id', 'concepto', 'estado', 'cuenta_contable']);
    }

    public function prestacionesSocialesDatos()
    {
        return ContablePrestacionSocial::all();
    }

    public function seguridadSocialDatos()
    {
        return ContableSeguridadSocial::all();
    }

    public function liquidacionDatos()
    {
        return ContableLiquidacion::all();
    }

    public function bancosCajaDatos()
    {
        return ContableBancoCaja::all();
    }

    /**
     * Crear nuevo Ingreso
     *
     * @return \Illuminate\Http\Response
     */
    public function storeIngresos()
    {
        $atributos = request()->validate([
            'concepto' => 'required',
            'tipo' => 'required',
            'cuenta_contable' => 'required',
            'estado' => 'required'
        ]);

        ContableIngreso::create($atributos);

        return response()->json(['message' => 'Ingreso creado correctamente!']);
    }

    /**
     * Crear nueva deducción
     *
     * @return \Illuminate\Http\Response
     */
    public function storeDeducciones()
    {
        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'estado' => 'required'
        ]);

        ContableDeduccion::create($atributos);

        return response()->json(['message' => 'Deducción creada correctamente!']);
    }
    /**
     * Crear nueva prestación social
     *
     * @return \Illuminate\Http\Response
     */
    public function storePrestacionesSociales()
    {
        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'contrapartida' => 'required',
            'estado' => 'required'
        ]);

        ContablePrestacionSocial::create($atributos);

        return response()->json(['message' => 'Prestación social creada correctamente!']);
    }
    /**
     * Crear nueva seguridad social
     *
     * @return \Illuminate\Http\Response
     */
    public function storeSeguridadSocial()
    {
        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'contrapartida' => 'required',
            'estado' => 'required'
        ]);

        ContableSeguridadSocial::create($atributos);

        return response()->json(['message' => 'Prestación social creada correctamente!']);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Actualizar salario subsidio
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSalarioSubsidio($id)
    {
        $salarioSubsidio = ContableSalarioSubsidioTransporte::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'contrapartida' => 'required',
            'estado' => 'required'
        ]);

        $salarioSubsidio->update($atributos);

        return response()->json(['message' => 'Dato actualizado correctamente']);
    }

    public function updateIngresos($id)
    {
        $ingreso = ContableIngreso::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required',
            'tipo' => 'required',
            'cuenta_contable' => 'required',
            'estado' => 'required'
        ]);

        $ingreso->update($atributos);

        return response()->json(['message' => 'Ingreso actualizado correctamente']);
    }


    public function updateLicenciasIncapacidades($id)
    {
        $licenciaIncapacidad = ContableLicenciaIncapacidad::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'estado' => 'required',
        ]);

        $licenciaIncapacidad->update($atributos);

        return response()->json(['message' => 'Dato actualizado correctamente!']);
    }


    public function updateDeducciones($id)
    {
        $deduccion = ContableDeduccion::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'estado' => 'required',
        ]);

        $deduccion->update($atributos);

        return response()->json(['message' => 'Dato actualizado correctamente!']);
    }

    public function updatePrestacionesSociales($id)
    {
        $prestacion = ContablePrestacionSocial::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'contrapartida' => 'required',
            'estado' => 'required',
        ]);

        $prestacion->update($atributos);

        return response()->json(['message' => 'Dato actualizado correctamente!']);
    }


    public function updateSeguridadSocial($id)
    {
        $prestacion = ContableSeguridadSocial::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'contrapartida' => 'required',
            'estado' => 'required',
        ]);

        $prestacion->update($atributos);

        return response()->json(['message' => 'Dato actualizado correctamente!']);
    }

    public function updateLiquidacion($id)
    {
        $liquidacion = ContableLiquidacion::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'estado' => 'required',
        ]);

        $liquidacion->update($atributos);

        return response()->json(['message' => 'Dato actualizado correctamente!']);
    }


    public function updateBancosCaja($id)
    {
        $banco = ContableBancoCaja::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required',
            'cuenta_contable' => 'required',
            'estado' => 'required',
        ]);

        $banco->update($atributos);

        return response()->json(['message' => 'Dato actualizado correctamente!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
