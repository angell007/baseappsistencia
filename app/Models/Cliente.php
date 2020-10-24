<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $guarded = ['id'];
    protected $table = 'cliente';

    protected $hidden = ['created_at', 'updated_at'];




}