<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $connection = 'tenant';
    protected $guarded = ['id'];
    protected $table = 'empresa';
    protected $casts = [
        'ley_1607' => 'boolean',
        'ley_1429' => 'boolean',
        'ley_590' => 'boolean'
    ];

    public function configuracionPago()
    {
        return $this->hasOne(EmpresaConfiguracion::class);
    }

    public function arl()
    {
        return $this->belongsTo(Arl::class);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }
}
