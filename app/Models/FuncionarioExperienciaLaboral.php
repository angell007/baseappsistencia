<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuncionarioExperienciaLaboral extends Model
{
    protected $guarded = ['id'];
    protected $table = 'funcionario_experiencia_laboral';



    /**
     * Una experiencia laboral pertenece a un funcionario
     *
     * @return void
     */
    public function funcionario() {
        return $this->belongsTo(Funcionario::class);
    }
}
