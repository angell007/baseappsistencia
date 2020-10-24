<?php

use App\Http\Controllers\PaginaPrincipalController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;


Route::get('/administracion', function () {
    return view('welcome');
});

Route::resource('tenants', TenantController::class);
Route::get('/{excepcion}', [PaginaPrincipalController::class, 'index'])->where('excepcion', '^(?!api\/)[\/\w\.-]*');

