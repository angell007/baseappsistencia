<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Novedad;
use App\Models\ContableLicenciaIncapacidad;

class NovedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('novedades.index');
    }

    public function getDatos($fechaInicio, $fechaFin)
    {
        return Novedad::with(['funcionario' => function ($query) {
            $query->select(['id', 'nombres', 'apellidos', 'image', 'dependencia_id'])->with('dependencia:id,nombre');
        }])->with('novedad')->where('fecha_inicio', '>=', $fechaInicio)
            ->where('fecha_fin', '<=', $fechaFin)->get();
    }

    public function getFuncionarios()
    {
        return Funcionario::get(['id', 'nombres', 'apellidos', 'dependencia_id']);
    }

    public function getNovedades()
    {
        return ContableLicenciaIncapacidad::get(['id', 'concepto']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'contable_licencia_incapacidad_id' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'tipo' => 'required',
            'modalidad' => 'required',
            'observacion' => '',
        ], [
            'funcionario_id.required' => 'El campo de funcionario es obligatorio',
            'contable_licencia_incapacidad_id.required' => 'El campo de novedad es obligatorio'
        ]);

        Novedad::create($atributos);

        return response()->json(['message' => 'Novedad creada correctamente']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $novedad = Novedad::findOrFail($id);

        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'contable_licencia_incapacidad_id' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'tipo' => 'required',
            'modalidad' => 'required',
            'observacion' => '',
        ], [
            'funcionario_id.required' => 'El campo de funcionario es obligatorio',
            'contable_licencia_incapacidad_id.required' => 'El campo de novedad es obligatorio'
        ]);

        $novedad->update($atributos);

        return response()->json(['message' => 'Novedad actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $novedad = Novedad::findOrFail($id);

        $novedad->delete();

        return response()->json(['message' => 'Novedad eliminada correctamente']);
    }
}
