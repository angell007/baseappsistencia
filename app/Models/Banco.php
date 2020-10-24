<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'bancos';
    protected $fillable = ['nombre', 'nit', 'editable'];
    protected $casts = ['editable' => 'boolean'];

    public function empresa()
    {
        return $this->hasOne(Empresa::class);
    }
}
