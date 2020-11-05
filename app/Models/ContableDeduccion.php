<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContableDeduccion extends Model
{
    protected $connection = 'tenant';

    protected $table = 'contable_deduccion';
    protected $guarded = ['id'];
    protected $casts = ['estado' => 'boolean', 'editable' => 'boolean'];

    public function deducciones()
    {
        return $this->hasMany(Deduccion::class);
    }
}
