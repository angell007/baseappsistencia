<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurnoRotativo extends Model
{
    protected $connection = 'tenant';

    protected $guarded = ['id'];
    protected $table = 'turno_rotativo';
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
    public function horariosTurnoRotativo()
    {
        return $this->hasMany(HorarioTurnoRotativo::class);
    }

    public function diariosTurnoRotativo()
    {
        return $this->hasMany(DiarioTurnoRotativo::class);
    }
}
