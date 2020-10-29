<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LlegadaTarde extends Model
{
    protected $table = 'llegada_tarde';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Una llegada tarde pertenece a un funcionario
     *
     * @return void
     */
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    /**
     * Una llegada tarde pertenece a una dependencia
     *
     * @return void
     */
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    /**
     * Una llegada tarde pertenece a un centro de costo
     *
     * @return void
     */
    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centro_costo_id');
    }
}
