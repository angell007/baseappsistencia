<?php

namespace App\Http\Controllers;

use App\Models\CentroCosto;

class CentroCostosController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }


    public function getDatos()
    {
        return CentroCosto::get(['id', 'nombre', 'codigo', 'prefijo_cuenta_contable']);
    }

    public function getDatosWithDependencias()
    {
        return CentroCosto::has('dependencias')->with(['dependencias' => function ($query) {
            $query->has('cargos')->with('cargos');
        }])->get(['id', 'nombre', 'codigo']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $atributos = request()->validate([
            'nombre' => 'required||string|min:3',
            'codigo' => 'required|min:2',
            'prefijo_cuenta_contable' => 'required|min:2'
        ]);

        CentroCosto::create($atributos);

        return response()->json(['message' => 'Centro de costos creado correctamente']);
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
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $centro = CentroCosto::find($id);

        if (!$centro) {
            return response()->json(['message' => 'Centro de costos no encontrado'], 404);
        }

        $atributos = request()->validate([
            'nombre' => 'required||string|min:3',
            'codigo' => 'required|min:2',
            'prefijo_cuenta_contable' => 'required|min:2'
        ]);

        $centro->update($atributos);

        return response()->json(['message' => 'centro de costos actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $centro = CentroCosto::find($id);

        if (!$centro) {
            return response()->json(['message' => 'Centro de costos no encontrado'], 404);
        }

        $centro->delete();

        return response()->json(['message' => 'Centro de costos eliminado correctamente']);
    }
}
