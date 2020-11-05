<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContableLiquidacion extends Model
{
    protected $connection = 'tenant';

    protected $table = 'contable_liquidacion';
    protected $guarded = ['id'];
}
