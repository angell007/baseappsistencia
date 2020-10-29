<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arl extends Model
{
    protected $table = 'arl';
    protected $fillable = ['nombre', 'nit', 'cuenta_contable', 'editable'];
    protected $casts = [
        'editable' => 'boolean'
    ];

    public function empresa()
    {
        return $this->hasOne(Empresa::class);
    }
}
