<?php

use App\Http\Controllers\PaginaPrincipalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;


Route::get('/administracion', function () {
    return view('welcome');
});


// Auth::routes();
Route::get('/{excepcion}', [PaginaPrincipalController::class, 'index'])->where('excepcion', '^(?!api\/)[\/\w\.-]*');

