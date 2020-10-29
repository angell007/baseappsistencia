<?php

namespace App\Http\Controllers;

use App\Models\TipoContrato;

class TiposContratosController extends Controller
{

    public function getDatos()
    {
        return TipoContrato::get(['id', 'nombre', 'editable']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $atributos = request()->validate([
            'nombre' => 'required',
            'editable' => 'boolean'
        ]);

        TipoContrato::create($atributos);

        return response()->json(['message' => 'Tipo de Contrato Creado correctamente']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $contrato = TipoContrato::find($id);

        $atributos = request()->validate([
            'nombre' => 'required',
            'editable' => 'boolean'
        ]);

        $contrato->update($atributos);

        return response()->json(['message' => 'Contrato actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contrato = TipoContrato::find($id);

        $contrato->delete();

        return response()->json(['message' => 'Contrato eliminado correctamente']);
    }
}
