<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $guarded = ['id'];
    protected $table = 'mensaje';

    protected $hidden = ['created_at', 'updated_at'];


    public function Ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
