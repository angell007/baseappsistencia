<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContableLicenciaIncapacidad extends Model
{
    protected $connection = 'tenant';

    protected $table = 'contable_licencia_incapacidad';
    protected $guarded = ['id'];

    public function novedades()
    {
        return $this->hasMany(Novedad::class);
    }
}
