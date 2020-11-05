<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['nombre', 'codigo', 'prefijo_cuenta_contable'];
    protected $table = 'centro_costo';
    protected $hidden = ['created_at', 'updated_at'];

    /**
     *  Un grupo contiene varias dependencias
     *
     * @return void
     */
    public function dependencias()
    {
        return $this->hasMany(Dependencia::class);
    }

    /**
     * Un grupo contiene varios funcionarios
     *
     * @return void
     */
    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }

    public function llegadasTarde()
    {
        return $this->hasMany(LlegadaTarde::class);
    }
}
