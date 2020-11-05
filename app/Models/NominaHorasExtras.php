<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominaHorasExtras extends Model
{
    protected $connection = 'tenant';

    protected $table = 'nomina_horas_extras';
    protected $guarded = ['id'];

    public function scopePrefijo($query, $indice)
    {
        return $query->where('prefijo',$indice)->first(['porcentaje'])['porcentaje'];
    }

    public static function enviarPorcentajes($indices = [])
    {   
        $porcentajes = [];
        foreach($indices as $indice) {
            $porcentajes[$indice] = self::prefijo($indice);
        }
        return $porcentajes;

    }
}
