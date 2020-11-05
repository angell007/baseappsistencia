<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContablePrestacionSocial extends Model
{
    protected $connection = 'tenant';

    protected $table = 'contable_prestacion_social';
    protected $guarded = ['id'];
    protected $casts = ['estado' => 'boolean', 'editable' => 'boolean'];
}
