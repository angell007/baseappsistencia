<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoNominaFuncionario extends Model
{
    protected $table = 'pago_nomina_funcionario';

    protected $fillable = [
        'funcionario_id',
        'pago_nomina_id',
        'dias_trabajados',
        'salario',
        'auxilio_transporte',
        'retenciones_deducciones',
        'salario_neto'
    ];

    public function pagoNomina()
    {
        return $this->belongsTo(PagoNomina::class);
    }
}
