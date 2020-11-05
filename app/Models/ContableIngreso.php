<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContableIngreso extends Model
{
    protected $connection = 'tenant';

    protected $table = 'contable_ingreso';
    protected $guarded = ['id'];
    protected $casts = ['estado' => 'boolean', 'editable' => 'boolean'];

    public function ingresosPrestacionales()
    {
        return $this->hasMany(IngresoPrestacional::class);
    }

    public function ingresosNoPrestacionales()
    {
        return $this->hasMany(IngresoNoPrestacional::class);
    }

    public function scopeIngreso($query, $tipo)
    {
        return $query->where('tipo', '=', $tipo)->where('estado', '=', true)->get(['id', 'concepto', 'cuenta_contable', 'estado', 'tipo']);
    }
}
