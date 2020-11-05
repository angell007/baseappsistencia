<?php

namespace App\Observers;

use App\Models\Funcionario;
use App\Models\subMenu;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\DB;

class FuncionarioObserver
{
    /**
     * Handle the funcionario "created" event.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return void
     */
    public function created(Funcionario $funcionario)
    {
        $submenus = subMenu::all();

        foreach ($submenus  as  $submenu) {
            DB::connection('Tenantcy')->table('funcionario_submenu')->insert([
                ['funcionario_id' => $funcionario->id,
                'submenu_id' => $submenu->id],
            ]);
        }
       
    }

    /**
     * Handle the funcionario "updated" event.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return void
     */
    public function updated(Funcionario $funcionario)
    {
        //
    }

    /**
     * Handle the funcionario "deleted" event.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return void
     */
    public function deleted(Funcionario $funcionario)
    {
        //
    }

    /**
     * Handle the funcionario "restored" event.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return void
     */
    public function restored(Funcionario $funcionario)
    {
        //
    }

    /**
     * Handle the funcionario "force deleted" event.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return void
     */
    public function forceDeleted(Funcionario $funcionario)
    {
        //
    }
}
