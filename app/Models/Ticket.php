<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ticket';

    protected $hidden = ['created_at', 'updated_at'];


    public function Mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}
