<?php

use App\Http\Controllers\PaginaPrincipalController;
use App\Http\Controllers\TenantController;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
// use DatabaseSeeder;


Route::get('/administracion', function () {
    $sd = new DatabaseSeeder;
    $sd->run();
});

Route::resource('tenants', TenantController::class);
Route::get('/{excepcion}', [PaginaPrincipalController::class, 'index'])->where('excepcion', '^(?!api\/)[\/\w\.-]*');

