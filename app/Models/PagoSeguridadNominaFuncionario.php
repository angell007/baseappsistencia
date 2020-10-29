<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoSeguridadNominaFuncionario extends Model
{
    protected $table = 'pago_seguridad_social_nomina_funcionario';
    protected $fillable = [
        'funcionario_id',
        'pago_nomina_id',
        'salud',
        'pension',
        'riesgos',
        'sena',
        'icbf',
        'caja_compensacion',
        'total_seguridad_social',
        'total_parafiscales',
        'total_seguridad_social_parafiscales'
    ];

    public function pagoNomina()
    {
        return $this->belongsTo(PagoNomina::class);
    }
}
