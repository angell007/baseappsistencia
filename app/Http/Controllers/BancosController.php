<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class BancosController extends Controller
{
    public function index()
    {
        //Config::set("database.connections.mysql.database", 'geneticapp');
        $banco = new Banco();
        $banco->setConnection('mysql');
        DB::reconnect('mysql');
        return $banco->get(['id', 'nombre']);

    }
}
