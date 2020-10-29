<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $guarded = ['id'];
    protected $table = 'encuesta';
    protected $hidden = ['created_at', 'updated_at'];


    /**
     * Una encuesta puede tener varias Preguntas
     *
     * @return void
     */
    public function Preguntas()
    {
        return $this->hasMany(EncuestaPregunta::class);
    }

    public function Aplicadas()
    {
        return $this->hasMany(EncuestaFuncionario::class);
    }
}
