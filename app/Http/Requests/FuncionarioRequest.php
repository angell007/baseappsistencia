<?php

namespace App\Http\Requests;

use App\Models\Funcionario;
use Illuminate\Foundation\Http\FormRequest;

class FuncionarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $funcionario = Funcionario::findOrFail(request()->get('id'));

        return [
            'identidad' => 'required|min:3|max:10|unique:funcionario,identidad,' . $funcionario->id,
            'nombres' => 'required',
            'apellidos' => 'required',
            'liquidado' => 'required',
            'fecha_nacimiento' => 'required',
            'lugar_nacimiento' => '',
            'tipo_sangre' => 'required',
            'telefono' => '',
            'celular' => 'required|numeric',
            'email' => 'required|email|unique:funcionario,email,' . $funcionario->id,
            'direccion_residencia' => '',
            'estado_civil' => 'required',
            'grado_instruccion' => '',
            'titulo_estudio' => '',
            'talla_pantalon' => '',
            'tallas_botas' => '',
            'talla_bata' => '',
            'talla_camisa' => '',
            'image' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'salario' => 'required',
            'fecha_ingreso' => 'required',
            'fecha_retiro' => '',
            'numero_hijos' => 'required',
            'personId' => '',
            'persistedFaceId' => '',
            'fecha_retiro' => '',
            'sexo' => 'required',
            'jefe' => '',
            'eps_id' => 'required',
            'cesantias_id' => 'required',
            'pensiones_id' => 'required',
            'caja_compensacion_id' => 'required',
            'tipo_contrato_id' => 'required',
            'dependencia_id' => 'required',
            'cargo_id' => 'required',
            'jefe_id' => '',
            'tipo_turno' => 'required|string',
            'turno_fijo_id' => ''

        ];
    }
}
