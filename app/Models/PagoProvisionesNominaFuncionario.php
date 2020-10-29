<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoProvisionesNominaFuncionario extends Model
{
    protected $table = 'pago_provisiones_nomina_funcionario';

    protected $fillable = [
        'funcionario_id',
        'pago_nomina_id',
        'cesantias',
        'intereses_cesantias',
        'prima',
        'vacaciones',
        'dias_acumulados_vacaciones',
        'total_provisiones'
    ];

    public function pagoNomina()
    {
        return $this->belongsTo(PagoNomina::class);
    }
}
