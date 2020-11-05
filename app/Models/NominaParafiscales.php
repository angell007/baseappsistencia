<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominaParafiscales extends Model
{
    protected $connection = 'tenant';

    protected $table = 'nomina_parafiscales';
    protected $guarded = ['id'];
}
