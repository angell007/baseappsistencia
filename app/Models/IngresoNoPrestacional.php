<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngresoNoPrestacional extends Model
{
    protected $table = 'ingreso_no_prestacional';
    protected $guarded = ['id'];

    public function ingreso()
    {
        return $this->belongsTo(ContableIngreso::class,'contable_ingreso_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class,'funcionario_id');
    }

    public function scopeObtener($query, Funcionario $funcionario, $fechaInicio, $fechaFin)
    {
        return $query->where('funcionario_id',$funcionario->id)->whereBetween('created_at',[$fechaInicio,$fechaFin])->with('ingreso')->get();
    }
}
