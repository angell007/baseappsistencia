<?php

namespace App\Http\Controllers;

use App\Deduccion;
use App\Funcionario;
use App\ContableDeduccion;

class DeduccionesController extends Controller
{
    
    public function index()
    {
        return ContableDeduccion::all();
    }

    public function store()
    {
        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'contable_deduccion_id' => 'required',
            'valor' => 'required|gt:0',
        ]);

        Deduccion::create($atributos);

        return response()->json(['message' => 'Deducción creada correctamente']);
    }

    public function showFuncionario($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        return Deduccion::where('funcionario_id','=',$funcionario->id)->with('deduccion')->get();
    }

    public function destroy($id)
    {
        $deduccion = Deduccion::findOrFail($id);
        $deduccion->delete();

        return response()->json(['message' => 'Deducción eliminada correctamente']);
    }
}
