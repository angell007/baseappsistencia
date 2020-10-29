<?php

namespace App\Http\Controllers;

use App\Models\Jefe;

class JefesController extends Controller
{
    public function index()
    {
        return Jefe::all();
    }
}
