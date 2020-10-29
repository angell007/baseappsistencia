<?php

namespace App\Http\Controllers;

use App\Models\CajaCompensacion;

class CajasCompensacionController extends Controller
{
    public function getDatos()
    {
        return CajaCompensacion::get(['id', 'nombre', 'nit', 'editable']);
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
            'nit' => 'required|numeric'
        ]);

        CajaCompensacion::create($atributos);

        return response()->json(['message' => 'Caja de compensaciones creada correctamente'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $caja = CajaCompensacion::find($id);

        if (!$caja) {
            return response()->json(['message' => 'Caja de compensación no encontrada'], 404);
        }

        $atributos = request()->validate([
            'nombre' => 'required|min:3',
            'nit' => 'required|numeric|unique:caja_compensacion,nit,' . $caja->id,
        ]);

        $caja->update($atributos);

        return response()->json(['message' => 'Caja de compensaciones actualizada correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $caja = CajaCompensacion::find($id);
        if (!$caja) {
            return response()->json(['message' => 'Caja de compensación no encontrada'], 404);
        }
        $caja->delete();
        return response()->json(['message' => 'Caja de compensaciones eliminada correctamente']);
    }
}
