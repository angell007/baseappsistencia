<?php

namespace App\Http\Controllers;

use App\Banco;

class BancosController extends Controller
{
    public function index()
    {
        return Banco::get(['id', 'nombre']);
    }
}
