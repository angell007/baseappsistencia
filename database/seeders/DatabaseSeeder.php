<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Dependencia;
use App\CentroCosto;
use App\Cargo;
use App\Funcionario;
use App\Turno;
use App\Eps;
use App\Cesantia;
use App\Pension;
use App\CajaCompensacion;
use App\TipoContrato;
use App\FuncionarioContactoEmergencia;
use App\FuncionarioExperienciaLaboral;
use App\DiarioFijo;
use App\LlegadaTarde;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()

    {
        $this->call(UsersTableSeeder::class);
        $this->call(ContableSalarioSubsidioTransporteSeeder::class);
        $this->call(ContableIngresoSeeder::class);
        $this->call(ContableLicenciaIncapacidadSeeder::class);
        $this->call(ContableDeduccionSeeder::class);
        $this->call(ContablePrestacionSocialSeeder::class);
        $this->call(ContableSeguridadSocialSeeder::class);
        //$this->call(GrupoTableSeeder::class);
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // DB::table('centro_costo')->truncate();
        // DB::table('dependencia')->truncate();
        // DB::table('turno')->truncate();
        // DB::table('cargo')->truncate();
        // DB::table('tipo_contrato')->truncate();
        // DB::table('eps')->truncate();
        // DB::table('cesantias')->truncate();
        // DB::table('pensiones')->truncate();
        // DB::table('caja_compensacion')->truncate();
        // DB::table('funcionario')->truncate();
        // DB::table('funcionario_contacto_emergencia')->truncate();
        // DB::table('funcionario_experiencia_laboral')->truncate();
        // DB::table('horario')->truncate();
        // DB::table('diario_fijo')->truncate();
        // DB::table('llegada_tarde')->truncate();

        // $grupos = factory(CentroCosto::class, 10)->create();

        // $grupos->each(function ($grupo) {
        //     $dependencias = factory(Dependencia::class, 3)->create(['centro_costo_id' => $grupo->id]);
        //     $dependencias->each(function($dependencia) use ($grupo) {

        //         $funcionarios = factory(Funcionario::class,2)->create(['dependencia_id' => $dependencia->id,'centro_costo_id' => $grupo->id]);

        //         $funcionarios->each(function ($funcionario) {
        //             $diarioFijos = factory(DiarioFijo::class, 5)->create(['funcionario_id' => $funcionario->id]);
        //         });

        //         $funcionarios->each(function ($funcionario) use ($grupo,$dependencia) {
        //             $llegadasTarde = factory(LlegadaTarde::class,5)->create(['funcionario_id' => $funcionario->id, 'centro_costo_id' => $grupo->id, 'dependencia_id' => $dependencia->id]);
        //         });


        //     });
        // });

        // $turnos = factory(Turno::class,10)->create();
        // $cargos = factory(Cargo::class,15)->create();
        // $eps = factory(Eps::class, 10000)->create();
        // $cesantias = factory(Cesantia::class,10)->create();
        // $pensiones = factory(Pension::class,3)->create();
        // $caja = factory(CajaCompensacion::class,7)->create();
        // $contratos = factory(TipoContrato::class,10)->create();

        // $contactoEmergencia = factory(FuncionarioContactoEmergencia::class,10)->create();
        // $experienciaLaboral = factory(FuncionarioExperienciaLaboral::class,7)->create();

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
