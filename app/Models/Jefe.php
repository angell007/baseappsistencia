<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jefe extends Model
{
    protected $fillable = ['nombres', 'apellidos', 'cargo_id'];
    protected $table = 'jefes';
}
