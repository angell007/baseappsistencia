<?php

namespace App\Observers;

use App\Models\Cliente;
use App\Models\Plan;
use Database\Seeders\DatabaseSeeder;

class ClienteObserver
{
    /**
     * Handle the cliente "created" event.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return void
     */
    public function creating(Cliente $cliente)
    {
        $plan = Plan::where('nombre', 'starter')->first();
        $cliente->plan_id = $plan->id;
        $cliente->estado = 'activo';
    }

    /**
     * Handle the cliente "updated" event.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return void
     */
    public function updated(Cliente $cliente)
    {
        //
    }

    /**
     * Handle the cliente "deleted" event.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return void
     */
    public function deleted(Cliente $cliente)
    {
        //
    }

    /**
     * Handle the cliente "restored" event.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return void
     */
    public function restored(Cliente $cliente)
    {
        //
    }

    /**
     * Handle the cliente "force deleted" event.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return void
     */
    public function forceDeleted(Cliente $cliente)
    {
        //
    }
}
