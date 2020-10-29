<?php

namespace App\Http\Controllers;

use App\Models\Eps;

class EpsController extends Controller
{

    public function getDatos()
    {
        return Eps::get(['id', 'nombre', 'nit', 'editable']);
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
            'nit' => 'required|numeric|unique:eps',
            'editable' => 'boolean'
        ]);

        Eps::create($atributos);

        return response()->json(['message' => 'Eps Creada correctamente']);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $eps = Eps::find($id);

        if (!$eps) {
            return response()->json(['message' => 'Eps no encontrada'], 404);
        }

        $atributos = request()->validate([
            'nombre' => 'required|min:3',
            'nit' => 'required|numeric|unique:eps,nit,' . $eps->id,
            'editable' => 'boolean'
        ]);

        $eps->update($atributos);

        return response()->json(['message' => 'Eps actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eps = Eps::find($id);

        if (!$eps) {
            return response()->json(['message' => 'Eps no encontrada'], 404);
        }

        $eps->delete();

        return response()->json(['message' => 'Eps eliminada correctamente']);
    }
}
