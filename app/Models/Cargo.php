<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['nombre', 'dependencia_id'];
    protected $table = 'cargo';
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Un cargo pertenece a una dependencia
     *
     * @return void
     */
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    /** Un cargo lo pueden tener varios funcionarios */
    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}
