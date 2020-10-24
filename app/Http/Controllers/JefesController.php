<?php

namespace App\Http\Controllers;

use App\Jefe;

class JefesController extends Controller
{
    public function index()
    {
        return Jefe::all();
    }
}
