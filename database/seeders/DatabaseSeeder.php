<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use App\Models\subMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()

    {
        $this->call(EpsSeeder::class);
        $this->call(BancoSeeder::class);
        $this->call(CajaCompensacionSeeder::class);
        $this->call(ArlSeeder::class);
        $this->call(CentroCostoSeeder::class);
        $this->call(DependenciaSeeder::class);
        $this->call(CargoSeeder::class);
        $this->call(CesantiaSeeder::class);
        $this->call(ContableBancoCajaSeeder::class);
        $this->call(ContableDeduccionSeeder::class);
        $this->call(ContableIngresoSeeder::class);
        $this->call(ContableLicenciaIncapacidadSeeder::class);
        $this->call(ContableLicenciaIncapacidadSeeder::class);
        $this->call(ContableLiquidacionSeeder::class);

        $this->call(ContablePrestacionSocialSeeder::class);
        $this->call(ContableSalarioSubsidioTransporteSeeder::class);
        $this->call(ContableSeguridadSocialSeeder::class);

        $this->call(NominaHorasExtrasSeeder::class);
        $this->call(NominaIncapacidadesSeeder::class);
        $this->call(NominaParafiscalesSeeder::class);
        $this->call(NominaRiesgosArlSeeder::class);

        $this->call(NominaSeguridadSocialEmpresaSeeder::class);
        $this->call(NominaSeguridadSocialFuncionarioSeeder::class);

        $this->call(PensionSeeder::class);
        $this->call(TipoContratoSeeder::class);

        $this->call(HorarioTurnoFijoSeeder::class);
        $this->call(HorarioTurnoRotativoSeeder::class);
        $this->call(MesSeeder::class);

        $this->call(TurnoFijoSeeder::class);
        $this->call(HorarioTurnoRotativoSeeder::class);
        $this->call(EmpresaConfigSeeder::class);

    }
}
