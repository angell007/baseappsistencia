<?php

namespace App\Http\Controllers;

use App\Models\NominaHorasExtras;
use App\Models\NominaSeguridadSocialFuncionario;
use App\Models\NominaSeguridadSocialEmpresa;
use App\Models\NominaRiesgosArl;
use App\Models\NominaParafiscales;
use App\Models\NominaIncapacidades;
use App\Models\Funcionario;
use App\Models\Empresa;

class ParametrosNominaController extends Controller
{
    public function horasExtrasDatos()
    {
        return NominaHorasExtras::all();
    }

    public function horasExtrasPorcentajes()
    {
        return NominaHorasExtras::pluck('porcentaje','prefijo');
    }

    public function updateHorasExtras($id)
    {
        $horaExtra = NominaHorasExtras::findOrFail($id);
        $atributos = request()->validate([
            'concepto' => 'required|min:3',
            'prefijo' => 'required|min:3',
            'porcentaje' => 'required|gt:0'
        ]);

        $horaExtra->update($atributos);

        return response()->json(['message' => 'Hora extra/recargo actualizada correctamente!']);
    }

    public function sSocialFuncionarioDatos()
    {
        return NominaSeguridadSocialFuncionario::all();
    }

    public function updateSSocialFuncionario($id)
    {
        $sSocial = NominaSeguridadSocialFuncionario::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required|min:3',
            'prefijo' => 'required|min:3',
            'porcentaje' => 'required|gt:0'
        ]);

        $sSocial->update($atributos);
        return response()->json(['message' => 'Aportes de Seguridad social actualizados correctamente!']);

    }

    public function sSocialEmpresaDatos()
    {
        return NominaSeguridadSocialEmpresa::all();
    }

    public function updateSSocialEmpresa($id)
    {
        $sSocial = NominaSeguridadSocialEmpresa::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required|min:3',
            'prefijo' => 'required|min:3',
            'porcentaje' => 'required|gt:0|numeric'
        ]);

        $sSocial->update($atributos);
        return response()->json(['message' => 'Aportes de Seguridad social actualizados correctamente']);
    }

    public function riesgosArlDatos()
    {
        return NominaRiesgosArl::all();
    }

    public function updateRiesgosArl($id)
    {
        $riesgo = NominaRiesgosArl::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required|min:3',
            'prefijo' => 'required|min:3',
            'porcentaje' => 'required|gt:0|numeric'
        ]);

        $riesgo->update($atributos);
        return response()->json(['message' => 'Riesgo ARL actualizado correctamente!']);
    }

    public function parafiscalesDatos()
    {
        return NominaParafiscales::all();
    }

    public function updateParafiscales($id)
    {
        $parafiscales = NominaParafiscales::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required|min:3',
            'prefijo' => 'required|min:3',
            'porcentaje' => 'required|gt:0|numeric'
        ]);
        $parafiscales->update($atributos);
        return response()->json(['message' => 'Parafiscales actualizados correctamente!']);
    }

    public function incapacidadesDatos()
    {
        return NominaIncapacidades::all();
    }

    public function updateIncapacidades($id)
    {
       $incapacidad = NominaIncapacidades::findOrFail($id);

        $atributos = request()->validate([
            'concepto' => 'required|min:3',
            'prefijo' => 'required|min:3',
            'porcentaje' => 'required|gt:0|numeric'
        ]);
        $incapacidad->update($atributos);
        return response()->json(['message' => 'Incapacidades actualizadas correctamente!']);
    }

    public function porcentajesSeguridadRiesgos($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $salarioMinimo = Empresa::first()['salario_base'];
        $riesgos = NominaRiesgosArl::where('id',$funcionario->nomina_riesgos_arl_id)->pluck('porcentaje','prefijo');
        $seguridad = NominaSeguridadSocialEmpresa::pluck('porcentaje','prefijo');
        $parafiscales = NominaParafiscales::pluck('porcentaje','prefijo');

        if(Empresa::first(['ley_1607']) && $funcionario->salario < ($salarioMinimo * 10)) {
           $seguridad['salud'] = 0;
           $parafiscales['sena'] = 0;
           $parafiscales['icbf'] = 0;
        }

        return $seguridad->merge(['riesgos'=>$riesgos->values()->first()])->merge($parafiscales);
    }
}
