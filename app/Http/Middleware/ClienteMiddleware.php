<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClienteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // return response()->json(auth()->user());
        return $next($request);
    }
}

/**
 * 
 * statrted 10 usuarios activos todos 
 * basic sin nomina 200
 * full todo 200 empleados 
 * Cliente activo o inactivo no crear,
 */
