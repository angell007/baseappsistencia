<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cesantia extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['nombre', 'nit', 'editable'];
    protected $table = 'cesantias';
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['editable' => 'boolean'];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}
