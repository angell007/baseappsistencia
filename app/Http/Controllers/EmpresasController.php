<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Admin;
//use Auth;
//use Illuminate\Support\Facades\Auth as Auth1;

class EmpresasController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('general.index');
    }


    public function getDatos(Request $request)
    {
        $id_empresa = $request->user()->empresa_id;
        return Empresa::with('configuracionPago')->with('arl')->with('banco')->find($id_empresa);
    }

    public function getGlobal()
    {
        return Empresa::with('configuracionPago')->with('arl')->first(['id', 'arl_id', 'frecuencia_pago', 'razon_social', 'numero_documento',
         'auxilio_transporte', 'salario_base', 'ley_1607']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $atributos = request()->validate([
            'razon_social' => 'required|min:3',
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'fecha_constitucion' => 'required',
            'email_contacto' => 'required|email|unique:empresa',
            'telefono_contacto' => 'required',
            'max_horas_extras' => 'required',
            'max_festivos_legales' => 'required',
            'max_llegadas_tarde' => 'required',
            'salario_base' => 'required',
            'auxilio_transporte' => 'required',
            'hora_inicio_noche' => 'required',
            'hora_fin_noche' => 'required',
            'festivos' => '',
            'frecuencia_pago' => 'required',
            'medio_pago' => 'required',
            'banco_id' => 'required',
            'tipo_cuenta' => 'required',
            'numero_cuenta' => 'required|min:10|max:20',
            'operador_pago' => 'required',
            'arl_id' => 'required',
            'ley_1429' => 'required',
            'ley_590' => 'required',
            'ley_1607' => 'required',
        ]);

        Empresa::create($atributos);

        return response()->json(['message' => 'Empresa registrada correctamente!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $empresa = Empresa::findOrFail($id);

        $atributos = request()->validate([
            'razon_social' => 'required|min:3',
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'fecha_constitucion' => 'required',
            'email_contacto' => 'required|email|unique:empresa,email_contacto,' . $empresa->id,
            'telefono_contacto' => 'required',
            'max_horas_extras' => 'required',
            'max_festivos_legales' => 'required',
            'max_llegadas_tarde' => 'required',
            'salario_base' => 'required',
            'auxilio_transporte' => 'required',
            'hora_inicio_noche' => 'required',
            'hora_fin_noche' => 'required',
            'festivos' => '',
            'frecuencia_pago' => 'required',
            'medio_pago' => 'required',
            'banco_id' => 'required',
            'tipo_cuenta' => 'required',
            'numero_cuenta' => 'required|min:10|max:20',
            'operador_pago' => 'required',
            'arl_id' => 'required',
            'ley_1429' => 'required',
            'ley_590' => 'required',
            'ley_1607' => 'required',
        ]);

        $empresa->update($atributos);

        return response()->json(['message' => 'Datos de la empresa actualizados correctamente']);
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
