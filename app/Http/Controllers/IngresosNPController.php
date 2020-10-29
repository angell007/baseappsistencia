<?php

namespace App\Http\Controllers;

use App\Models\IngresoNoPrestacional;
use App\Models\Funcionario;

class IngresosNPController extends Controller
{
    public function store()
    {
        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'contable_ingreso_id' => 'required',
            'valor' => 'required|gt:0',
        ]);

        IngresoNoPrestacional::create($atributos);

        return response()->json(['message' => 'Ingreso no prestacional creado correctamente']);
    }

    public function showFuncionario($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        return IngresoNoPrestacional::where('funcionario_id','=',$funcionario->id)->with('ingreso')->get();
    }

    public function destroy($id)
    {
        $ingreso = IngresoNoPrestacional::findOrFail($id);
        $ingreso->delete();

        return response()->json(['message' => 'Ingreso no prestacional eliminado correctamente']);
    }
}
