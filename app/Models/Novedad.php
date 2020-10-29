<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Novedad extends Model
{
    protected $table = 'novedad';
    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function novedad()
    {
        return $this->belongsTo(ContableLicenciaIncapacidad::class, 'contable_licencia_incapacidad_id');
    }

    public function scopeVacaciones($query, Funcionario $funcionario, $fechaInicio)
    {
        return $query->where('funcionario_id', $funcionario->id)->where('tipo', 'Vacaciones')->where('fecha_inicio', '>=', $fechaInicio)->with('novedad')->get();
    }

    public function scopeNovedades($query, Funcionario $funcionario, $fechaFin)
    {
        $anioFechaFin = Carbon::parse($fechaFin)->year;

        return $query->where('funcionario_id', $funcionario->id)->with('novedad')->whereHas('novedad', function ($query) {
            $query->where('concepto', '<>', 'Vacaciones');
        })->whereYear('fecha_fin', '=', $anioFechaFin);
    }
}
