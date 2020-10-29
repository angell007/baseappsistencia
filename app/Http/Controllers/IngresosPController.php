<?php

namespace App\Http\Controllers;

use App\Models\IngresoPrestacional;
use App\Models\Funcionario;

class IngresosPController extends Controller
{
    public function store()
    {
        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'contable_ingreso_id' => 'required',
            'valor' => 'required|gt:0',
        ]);

        IngresoPrestacional::create($atributos);

        return response()->json(['message' => 'Ingreso prestacional creado correctamente']);
    }

    public function showFuncionario($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        return IngresoPrestacional::where('funcionario_id','=',$funcionario->id)->with('ingreso')->get();
    }

    public function destroy($id)
    {
        $ingreso = IngresoPrestacional::findOrFail($id);
        $ingreso->delete();

        return response()->json(['message' => 'Ingreso prestacional eliminado correctamente']);
    }
}
