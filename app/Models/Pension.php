<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pension extends Model
{
    protected $fillable = ['nombre', 'nit', 'cuenta_contable', 'editable'];
    protected $table = 'pensiones';
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['editable' => 'boolean'];


    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}
