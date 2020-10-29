<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuncionarioReferenciaPersonal extends Model
{
    protected $fillable = ['funcionario_id', 'nombre_completo','profesion','telefono','celular'];
    protected $table = 'funcionario_referencia_personal';



    /**
     * Una referencia personal pertenece a un funcionario
     *
     * @return void
     */
    public function funcionario() {
        return $this->belongsTo(Funcionario::class);
    }
}
