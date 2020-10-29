<?php

namespace App\Http\Controllers;

use App\Models\TurnoRotativo;
use App\Models\TurnoFijo;

class TurnosController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function getDatosTurnosRotativos()
    {
        return TurnoRotativo::all();
    }

    public function getDatosTurnosFijos()
    {
        return TurnoFijo::with('horariosTurnoFijo')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeTurnoRotativo()
    {
        $atributos = request()->validate([
            'nombre' => 'required',
            'extras' => 'required',
            'tolerancia_entrada' => 'required',
            'tolerancia_salida' => 'required',
            'hora_inicio_uno' => 'required',
            'hora_fin_uno' => 'required',
            'hora_inicio_dos' => '',
            'hora_fin_dos' => '',
            'jornada_turno' => 'required',
            'color' => 'required',
        ]);
        $turno = TurnoRotativo::create($atributos);

        return response()->json(['message' => 'Turno Creado correctamente', 'id' => $turno->id]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeTurnoFijo()
    {
        $atributos = request()->validate([
            'nombre' => 'required',
            'extras' => 'required',
            'tolerancia_entrada' => 'required',
            'tolerancia_salida' => 'required',
            'color' => 'required',
        ]);
        $turno = TurnoFijo::create($atributos);

        return response()->json(['message' => 'Turno Creado correctamente', 'id' => $turno->id]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTurnoRotativo($id)
    {
        $turno = TurnoRotativo::find($id);

        $atributos = request()->validate([
            'nombre' => 'required',
            'extras' => 'required',
            'tolerancia_entrada' => 'required',
            'tolerancia_salida' => 'required',
            'hora_inicio_uno' => 'required',
            'hora_fin_uno' => 'required',
            'hora_inicio_dos' => '',
            'hora_fin_dos' => '',
            'jornada_turno' => 'required',
            'color' => 'required',
        ]);

        $turno->update($atributos);

        return response()->json(['message' => 'Turno Actualizado Correctamente']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int   $id
     * @return \Illuminate\Http\Response
     */
    public function updateTurnoFijo($id)
    {
        $turno = TurnoFijo::find($id);

        $atributos = request()->validate([
            'nombre' => 'required',
            'extras' => 'required',
            'tolerancia_entrada' => 'required',
            'tolerancia_salida' => 'required',
            'color' => 'required',
        ]);

        $turno->update($atributos);

        return response()->json(['message' => 'Turno Actualizado Correctamente', 'id' => $turno->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int   $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTurnoRotativo($id)
    {
        $turno = TurnoRotativo::find($id);

        $turno->delete();

        return response()->json(['message' => 'Turno Eliminado Correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int   $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTurnoFijo($id)
    {
        $turno = TurnoFijo::find($id);

        $turno->delete();

        return response()->json(['message' => 'Turno Eliminado Correctamente']);
    }
}
