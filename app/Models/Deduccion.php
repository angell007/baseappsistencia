<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduccion extends Model
{
    protected $table = 'deduccion';
    protected $guarded = ['id'];

    public function deduccion()
    {
        return $this->belongsTo(ContableDeduccion::class, 'contable_deduccion_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }

    public function scopePeriodo($query, Funcionario $funcionario, $fechaInicio, $fechaFin)
    {
        return $query->where('funcionario_id', '=', $funcionario->id)->whereBetween('created_at', [$fechaInicio, $fechaFin])->with('deduccion')->get();
    }
}
