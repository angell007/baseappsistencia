<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContableBancoCaja extends Model
{
    protected $connection = 'tenant';
    protected $table = 'contable_banco_caja';
    protected $guarded = ['id'];
}
