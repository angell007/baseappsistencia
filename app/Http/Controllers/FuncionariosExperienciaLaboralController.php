<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Funcionario;
use App\FuncionarioExperienciaLaboral;

class FuncionariosExperienciaLaboralController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($identidad)
    {
        $funcionario = Funcionario::where('identidad', $identidad)->first();

        if (!$funcionario) {
            return response()->json(['message' => 'Funcionario no encontrado'], 404);
        }

        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'nombre_empresa' => 'required',
            'cargo' => '',
            'fecha_ingreso' => '',
            'fecha_retiro' => '',
            'labores' => '',
            'nombre_jefe' => '',
            'telefono_empresa' => 'required'
        ]);

        FuncionarioExperienciaLaboral::create($atributos);

        return response()->json(['message' => 'Experiencia Laboral creada correctamente']);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
