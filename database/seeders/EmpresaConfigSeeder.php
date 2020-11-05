<?php

namespace Database\Seeders;

use App\Models\EmpresaConfiguracion;
use Illuminate\Database\Seeder;

class EmpresaConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        EmpresaConfiguracion::create([
            'calculo_incapacidad_general' => 'del 100 % al 66,67%',
            'pago_deducciones' => 'proporcionales',
            'pago_recurrente' => 'proporcionales',
            'pago_subsidio_transporte' => 'quincenal',
            'afecta_subsidio_transporte' => '1',
            'pagar_vacaciones_31' => '0',
            'empresa_id' => '1'
        ]);
    }



    // INSERT INTO `empresa_configuracion_pago` (`
    // id`,
    // `calculo_incapacidad_general
    // `, `pago_deducciones`, `pago_recurrente`, `pago_subsidio_transporte`, `afecta_subsidio_transporte`, `pagar_vacaciones_31`, `empresa_id`, `created_at`, `updated_at`) VALUES
    // (1, 'del 100 % al 66,67%', 'proporcionales', 'proporcionales', 'quincenal', 1, 0, 1, '2019-05-30 19:17:37', '2019-05-30 19:17:37');

}
