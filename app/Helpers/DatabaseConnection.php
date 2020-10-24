<?php

namespace App\Helpers;

use Config;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class DatabaseConnection
{
    public static function setConnection()
    {
        config(['database.connections.Tenantcy' => [
            'database' => 'tenantfoo',
        ]]);

        return FacadesDB::connection('Tenantcy');
    }
}
