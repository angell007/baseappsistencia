<?php

namespace App\Http\Controllers;

use App\Models\Cargo;

class CargosController extends Controller
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
    public function index()
    {
        return view('cargos.index');
    }

    public function getDatos()
    {
        return Cargo::with('dependencia')->get();
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
            'dependencia_id' => 'required'
        ]);

        Cargo::create($atributos);

        return response()->json(['message' => 'Cargo Creado correctamente']);
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
        $cargo = Cargo::find($id);

        $atributos = request()->validate([
            'nombre' => 'required',
            'dependencia_id' => 'required'
        ]);

        $cargo->update($atributos);

        return response()->json(['message' => 'Cargo actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cargo = Cargo::find($id);

        $cargo->delete();

        return response()->json(['message' => 'Cargo eliminado correctamente']);
    }
}
