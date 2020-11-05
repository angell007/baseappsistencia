<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurnoFijo extends Model
{
    protected $connection = 'tenant';

    protected $guarded = ['id'];
    protected $table = 'turno_fijo';
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Un turno lo pueden tener varios usuarios
     *
     * @return void
     */
    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
    /**
     * Un turno puede tener varias horas turno
     *
     * @return void
     */
    public function horariosTurnoFijo()
    {
        return $this->hasMany(HorarioTurnoFijo::class);
    }

    public function diariosTurnoFijo()
    {
        return $this->hasMany(DiarioTurnoFijo::class);
    }
}
