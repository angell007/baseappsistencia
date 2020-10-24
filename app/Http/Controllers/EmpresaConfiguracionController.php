<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmpresaConfiguracion;
use Auth;

class EmpresaConfiguracionController extends Controller
{

    public function index(Request $request)
    {

        $id_empresa = $request->user()->empresa_id;
        $empresaConfiguracion =  EmpresaConfiguracion::first();
        if (!$empresaConfiguracion) {
            return response()->json(['message' => 'Configuración no encontrada', 'status' => 404], 404);
        }
        return $empresaConfiguracion;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $atributos = request()->validate([
            'empresa_id' => 'required',
            'calculo_incapacidad_general' => 'required',
            'pago_deducciones' => 'required',
            'pago_recurrente' => 'required',
            'pago_subsidio_transporte' => 'required',
            'afecta_subsidio_transporte' => 'required',
            'pagar_vacaciones_31' => 'required',
        ]);

        EmpresaConfiguracion::create($atributos);

        return response()->json(['message' => 'Configuración de Pago Creada Correctamente'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $configuracion = EmpresaConfiguracion::find($id);

        if (!$configuracion) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        return $configuracion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $configuracion = EmpresaConfiguracion::findOrFail($id);

        $atributos = request()->validate([
            'empresa_id' => 'required',
            'calculo_incapacidad_general' => 'required',
            'pago_deducciones' => 'required',
            'pago_recurrente' => 'required',
            'pago_subsidio_transporte' => 'required',
            'afecta_subsidio_transporte' => 'required',
            'pagar_vacaciones_31' => 'required',
        ]);

        $configuracion->update($atributos);

        return response()->json(['message' => 'Configuración de Pago Actualizada Correctamente'], 200);
    }
}
