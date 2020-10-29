<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaPreguntaOpcion extends Model
{
    protected $guarded = ['id'];
    protected $table = 'encuesta_pregunta_opcion';


    /**
     * Una Pregunta de Encuesta pertenece a una Encuesta
     *
     * @return void
     */
    public function Pregunta()
    {
        return $this->belongsTo(EncuestPregunta::class,'encuesta_pregunta_id');
    }

}
