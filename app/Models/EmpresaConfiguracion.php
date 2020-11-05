<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaConfiguracion extends Model
{
    protected $connection = 'tenant';

    protected $table = 'empresa_configuracion_pago';
    protected $guarded = ['id'];
    protected $casts = [
        'afecta_subsidio_transporte' => 'boolean',
        'pagar_vacaciones_31' => 'boolean'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
