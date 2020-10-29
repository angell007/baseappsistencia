<?php

namespace App\Http\Controllers;

use App\Models\Cesantia;

class CesantiasController extends Controller
{
    public function getDatos()
    {
        return Cesantia::get(['id', 'nombre', 'nit', 'editable']);
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
            'nit' => 'required|numeric|unique:cesantias'
        ]);

        Cesantia::create($atributos);

        return response()->json(['message' => 'Fondo de cesantías creado correctamente']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $fondo = Cesantia::find($id);
        if (!$fondo) {
            return response()->json(['messsage' => 'Fondo de cesantías no encontrado'], 404);
        }

        $atributos = request()->validate([
            'nombre' => 'required|min:3',
            'nit' => 'required|numeric|unique:cesantias,nit,' . $fondo->id,
        ]);

        $fondo->update($atributos);

        return response()->json(['message' => 'Fondo de cesantías actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fondo = Cesantia::find($id);

        if (!$fondo) {
            return response()->json(['messsage' => 'Fondo de cesantías no encontrado'], 404);
        }

        $fondo->delete();

        return response()->json(['message' => 'Fondo de cesantías eliminado correctamente']);
    }
}
