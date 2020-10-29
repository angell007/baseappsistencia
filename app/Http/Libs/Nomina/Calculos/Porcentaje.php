<?php

namespace App\Http\Libs\Nomina\Calculos;

use App\Models\NominaSeguridadSocialEmpresa;
use App\Models\NominaRiesgosArl;
use App\Models\Funcionario;
use App\Models\NominaParafiscales;
use App\Models\NominaSeguridadSocialFuncionario;


trait Porcentaje
{

    public function porcentajePension()
    {
        return NominaSeguridadSocialEmpresa::where('prefijo', '=', 'pension')->first()['porcentaje'];
    }

    public function porcentajeSalud()
    {
        return NominaSeguridadSocialEmpresa::where('prefijo', '=', 'salud')->first()['porcentaje'];
    }

    public function porcentajeRiesgosArl(Funcionario $funcionario)
    {
        return NominaRiesgosArl::where('id', $funcionario->nomina_riesgos_arl_id)->first()['porcentaje'];
    }

    public function porcentajeSena()
    {
        return NominaParafiscales::where('prefijo', '=', 'sena')->first()['porcentaje'];
    }

    public function porcentajeIcbf()
    {
        return NominaParafiscales::where('prefijo', '=', 'icbf')->first()['porcentaje'];
    }

    public function porcentajeCajaCompensacion()
    {
        return NominaParafiscales::where('prefijo', '=', 'caja_compensacion')->first()['porcentaje'];
    }

    public function porcentajePensionFunc()
    {
        return NominaSeguridadSocialFuncionario::where('prefijo', '=', 'pension')->first()['porcentaje'];
    }

    public function porcentajeSaludFunc()
    {
        return NominaSeguridadSocialFuncionario::where('prefijo', '=', 'salud')->first()['porcentaje'];
    }

    public function porcentajeFondoSolidaridad()
    {
        return NominaSeguridadSocialFuncionario::where('prefijo', '=', 'fondo_solidaridad')->first()['porcentaje'];
    }

    public function porcentajesFondoSubsistencia()
    {
        return NominaSeguridadSocialFuncionario::pluck('porcentaje', 'prefijo');
    }
}
