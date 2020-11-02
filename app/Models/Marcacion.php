<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marcacion extends Model
{
    protected $table = 'marcacion';
    protected $fillable = ['tipo', 'detalles', 'fecha'];

}
