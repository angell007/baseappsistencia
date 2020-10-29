<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaFuncionarioRespuesta extends Model
{
    protected $guarded = ['id'];
    protected $table = 'encuesta_funcionario_respuesta';
    protected $hidden = ['created_at', 'updated_at'];


    /**
     * Una Pregunta de Encuesta pertenece a una Encuesta
     *
     * @return void
     */
    public function EncuestaFuncionario()
    {
        return $this->belongsTo(EncuestaFuncionario::class,'encuesta_funcionario_id');
    }
    public function EncuestaPregunta()
    {
        return $this->belongsTo(EncuestaPregunta::class,'encuesta_pregunta_id');
    }
}
