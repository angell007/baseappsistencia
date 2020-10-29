<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuncionarioDocumento extends Model
{
    protected $fillable = ['funcionario_id', 'nombre_documento'];
    protected $table = 'funcionario_documento';


    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }
}
