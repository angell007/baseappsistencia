<?php

namespace App\Http\Controllers;

use App\Arl;

class ArlController extends Controller
{
    public function index()
    {
        return Arl::get(['id', 'nombre']);
    }
}
