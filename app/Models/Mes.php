<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    protected $guarded = ['id'];
    protected $table = 'mes';

    protected $hidden = ['created_at', 'updated_at'];




}