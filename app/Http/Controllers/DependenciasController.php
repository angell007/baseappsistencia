<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;

class DependenciasController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDatos()
    {
        return Dependencia::with('centroCosto')->get();
    }

    public function getDatosWithCargos()
    {
        return Dependencia::with('centroCosto')->with('cargos')->get();
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
            'centro_costo_id' => 'required'
        ]);

        Dependencia::create($atributos);

        return response()->json(['message' => 'Dependencia creada correctamente']);
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
        $dependencia = Dependencia::find($id);

        $atributos = request()->validate([
            'nombre' => 'required',
            'centro_costo_id' => 'required'
        ]);

        $dependencia->update($atributos);

        return response()->json(['message' => 'Dependencia actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dependencia = Dependencia::find($id);

        $dependencia->delete();

        return response()->json(['message' => 'Dependencia eliminada correctamente']);
    }
}
