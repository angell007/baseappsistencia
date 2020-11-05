<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominaIncapacidades extends Model
{
    protected $connection = 'tenant';

    protected $table = 'nomina_incapacidades';
    protected $guarded = ['id'];
}
