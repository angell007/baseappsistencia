<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subMenu extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $fillable = [
        'item',
        'icon',
        'url',
        'menu_id'
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }
}
