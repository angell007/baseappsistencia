<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContableLicenciaIncapacidad extends Model
{
    protected $table = 'contable_licencia_incapacidad';
    protected $guarded = ['id'];

    public function novedades()
    {
        return $this->hasMany(Novedad::class);
    }
}
