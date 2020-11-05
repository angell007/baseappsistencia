<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContableSalarioSubsidioTransporte extends Model
{
    protected $connection = 'tenant';

    protected $table = 'contable_salario_subsidio_transporte';

    protected $guarded = ['id'];
}
