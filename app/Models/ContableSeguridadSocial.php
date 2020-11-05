<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContableSeguridadSocial extends Model
{
    protected $connection = 'tenant';

    protected $table = 'contable_seguridad_social';
    protected $guarded = ['id'];
    protected $casts = ['estado' => 'boolean', 'editable' => 'boolean'];
}
