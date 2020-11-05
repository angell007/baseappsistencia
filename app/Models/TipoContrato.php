<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    protected $connection = 'tenant';

    protected $fillable = ['nombre', 'editable'];
    protected $table = 'tipo_contrato';
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['editable' => 'boolean'];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}
