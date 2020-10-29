<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteExtras extends Model
{
    protected $table = 'reporte_extras';
    protected $guarded = ['id'];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class,'funcionario_id');
    }

    
}
