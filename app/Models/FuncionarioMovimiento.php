<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuncionarioMovimiento extends Model
{
    protected $fillable = [];
    protected $table = 'funcionario_movimiento';



    /**
     * Un movimiento es realizado por un funcionario
     *
     * @return void
     */
    public function funcionario() {
        return $this->belongsTo(Funcionario::class);
    }
}
