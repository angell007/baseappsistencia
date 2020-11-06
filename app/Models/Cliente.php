<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $connection = 'mysql';
    protected $guarded = ['id'];
    protected $table = 'cliente';
    protected $hidden = ['created_at', 'updated_at'];

    public function plan()
    {
       return $this->belongsTo(Plan::class);
    }

}
