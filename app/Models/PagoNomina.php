<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoNomina extends Model
{
    protected $table = 'pago_nomina';
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'admin_id',
        'inicio_periodo',
        'fin_periodo',
        'total_salarios',
        'total_retenciones',
        'total_provisiones',
        'total_seguridad_social',
        'total_parafiscales',
        'total_extras_recargos',
        'total_ingresos',
        'costo_total',
    ];

    public function pagosNominaFuncionario()
    {
        return $this->hasMany(PagoNominaFuncionario::class);
    }

    public function pagosProvisionesNominaFuncionario()
    {
        return $this->hasMany(PagoProvisionesNominaFuncionario::class);
    }

    public function pagosSeguridadNominaFuncionario()
    {
        return $this->hasMany(PagoSeguridadNominaFuncionario::class);
    }


    /**
     * Query Scope utilizado para traer los días de vacaciones acumulados de un funcionario en el último periodo pagado de nómina, tambíen se incluyen las fechas de inicio y fin de ese periodo 
     *
     * @param QuerScope $query
     * @param integer $id
     * @return void
     */
    public function scopeVacacionesAcumuladasFuncionarioWithId($query, $id)
    {
        return $query->select('id', 'inicio_periodo', 'fin_periodo')->orderByRaw('inicio_periodo DESC, fin_periodo DESC')->with(['pagosProvisionesNominaFuncionario' => function ($query) use ($id) {
            $query->select('id', 'funcionario_id', 'pago_nomina_id', 'dias_acumulados_vacaciones')->where('funcionario_id', $id);
        }]);
    }
}
