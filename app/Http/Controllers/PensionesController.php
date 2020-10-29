<?php

namespace App\Http\Controllers;

use App\Models\Pension;

class PensionesController extends Controller
{
    public function getDatos()
    {
        return Pension::get(['id', 'nombre', 'nit', 'editable']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $atributos = request()->validate([
            'nombre' => 'required|min:3',
            'nit' => 'required|numeric|unique:pensiones|min:8',
            'editable' => 'boolean'
        ]);

        Pension::create($atributos);

        return response()->json(['message' => 'Fondo de pensiones creado correctamente']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $pension = Pension::find($id);

        if (!$pension) {
            return response()->json(['message' => 'Fondo de pensiones no encontrado'], 404);
        }

        $atributos = request()->validate([
            'nombre' => 'required|min:3',
            'nit' => 'required|numeric|min:8|unique:pensiones,nit,' . $pension->id,
            'editable' => 'boolean'
        ]);

        $pension->update($atributos);

        return response()->json(['message' => 'Fondo de pensiones actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pension = Pension::find($id);
        if (!$pension) {
            return response()->json(['message' => 'Fondo de pensiones no encontrado'], 404);
        }

        $pension->delete();

        return response()->json(['message' => 'Fondo de pensiones eliminado correctamente']);
    }
}
