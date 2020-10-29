<?php

namespace App\Http\Controllers;

use App\Models\PagoNomina;

class HistorialPagosController extends Controller
{
    /**
     * Retorna JSON todos los pagos de nómina hechos hasta la fecha
     *
     * @return Illuminate\Http\Response
     */
    public function getPagosNomina()
    {
        return PagoNomina::all();
    }
}
