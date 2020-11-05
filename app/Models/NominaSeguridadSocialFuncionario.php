<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominaSeguridadSocialFuncionario extends Model
{
    protected $connection = 'tenant';

    protected $table = 'nomina_seguridad_social_funcionario';
    protected $guarded = ['id'];
}
