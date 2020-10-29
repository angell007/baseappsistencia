<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaPregunta extends Model
{
    protected $guarded = ['id'];
    protected $table = 'encuesta_pregunta';
    protected $hidden = ['created_at', 'updated_at'];


    /**
     * Una Pregunta de Encuesta pertenece a una Encuesta
     *
     * @return void
     */
    public function Encuesta()
    {
        return $this->belongsTo(Encuesta::class,'encuesta_id');
    }
    /**
     * Una Pregunta de Encuesta puede tener muchas respuestas
     *
     * @return void
     */
    public function Respuestas()
    {
        return $this->hasMany(EncuestaFuncionarioRespuesta::class);
    }
    public function Opciones()
    {
        return $this->hasMany(EncuestaPreguntaOpcion::class);
    }
}
