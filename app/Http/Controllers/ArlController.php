<?php

namespace App\Http\Controllers;

use App\Models\Arl;

class ArlController extends Controller
{
    public function index()
    {
        return Arl::get(['id', 'nombre']);
    }
}
