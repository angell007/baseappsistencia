<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContablePrestacionSocial extends Model
{
    protected $table = 'contable_prestacion_social';
    protected $guarded = ['id'];
    protected $casts = ['estado' => 'boolean', 'editable' => 'boolean'];
}
