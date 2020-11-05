<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['nombre', 'centro_costo_id'];
    protected $table = 'dependencia';
    protected $hidden = ['created_at', 'updated_at'];


    /**
     * Una dependencia pertenece a un grupo
     *
     * @return void
     */
    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class);
    }

    /**
     * En una dependencia existen varios cargos
     *
     * @return void
     */
    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }

    /**
     * En una dependencia se realizan varios turnos
     *
     * @return void
     */
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    /**
     * Una dependencia tiene varios funcionarios
     *
     * @return void
     */
    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }

    /**
     * Una dependencia presenta varias llegadas tarde (hechas por sus funcionarios)
     *
     * @return void
     */
    public function llegadasTarde()
    {
        return $this->hasMany(LlegadaTarde::class);
    }
}
