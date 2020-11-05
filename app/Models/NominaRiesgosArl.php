<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominaRiesgosArl extends Model
{
    protected $connection = 'tenant';

    protected $table = 'nomina_riesgos_arl';
    protected $guarded = ['id'];
}
