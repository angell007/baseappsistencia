<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuncionarioContactoEmergencia extends Model
{
    protected $guarded = ['id'];
    protected $table = 'funcionario_contacto_emergencia';

    /**
     * Un contacto de emergencia pertenece a un funcionario
     *
     * @return void
     */
    public function funcionario() {
        return $this->belongsTo(Funcionario::class);
    }
}
