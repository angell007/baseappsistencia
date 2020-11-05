<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Menu;
use App\Models\Plan;
use App\Models\subMenu;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Plan::create([
            'nombre' => 'starter',
            'cantidad_users' => '10'
        ]);
        Plan::create([
            'nombre' => 'basic',
            'cantidad_users' => '200'
        ]);
        Plan::create([
            'nombre' => 'full',
            'cantidad_users' => '200'
        ]);

        Menu::create([
            'nombre' => 'Nomina',
            'descripcion' => 'Nómina',
            'icon' => 'iconsmind-Money-Bag'
        ]);
        Menu::create([
            'nombre' => 'Novedades',
            'descripcion' => 'Novedades',
            'icon' => 'iconsmind-Ticket'
        ]);
        Menu::create([
            'nombre' => 'Horarios',
            'descripcion' => 'Horarios',
            'icon' => 'iconsmind-Clock'
        ]);
        Menu::create([
            'nombre' => 'Indicadores',
            'descripcion' => 'Indicadores',
            'icon' => 'iconsmind-Line-Chart3'
        ]);
        Menu::create([
            'nombre' => 'Configuracion',
            'descripcion' => 'Configuración',
            'icon' => 'iconsmind-Gears-2'
        ]);
        Menu::create([
            'nombre' => 'Administrativo',
            'descripcion' => 'Administrativo',
            'icon' => 'iconsmind-Control'
        ]);
        Menu::create([
            'nombre' => 'App',
            'descripcion' => 'App',
            'icon' => 'iconsmind-Smartphone-2'
        ]);

        /******************************************************************************************************************* */
        subMenu::create([
            'item' => 'Pago de Nómina',
            'icon' => 'simple-icon-wallet',
            'url' => '/nomina/pago',
            'menu_id' => (Menu::where('nombre', 'Nomina')->first())->id
        ]);

        subMenu::create([
            'item' => 'Historial de Pagos',
            'icon' => 'simple-icon-briefcase',
            'url' => '/nomina/historial-pagos',
            'menu_id' => (Menu::where('nombre', 'Nomina')->first())->id
        ]);

        subMenu::create([
            'item' => 'Provisiones',
            'icon' => 'simple-icon-umbrella',
            'url' => '/nomina/provisiones',
            'menu_id' => (Menu::where('nombre', 'Nomina')->first())->id
        ]);

        subMenu::create([
            'item' => 'Liquidaciones',
            'icon' => 'simple-icon-people',
            'url' => '/nomina/liquidaciones',
            'menu_id' => (Menu::where('nombre', 'Nomina')->first())->id
        ]);

        /******************************************************************************************************************* */

        subMenu::create([
            'item' => 'Listado de Novedades',
            'icon' => 'simple-icon-bell',
            'url' => '/novedades',
            'menu_id' => (Menu::where('nombre', 'Novedades')->first())->id
        ]);

        subMenu::create([
            'item' => 'Llegadas Tarde',
            'icon' => 'simple-icon-hourglass',
            'url' => '/llegadas_tarde',
            'menu_id' => (Menu::where('nombre', 'Novedades')->first())->id
        ]);

        /******************************************************************************************************************* */
        subMenu::create([
            'item' => 'Turnos',
            'icon' => 'simple-icon-plus',
            'url' => '/turnos',
            'menu_id' => (Menu::where('nombre', 'Horarios')->first())->id
        ]);
        subMenu::create([
            'item' => 'Asignación de turnos',
            'icon' => 'simple-icon-calendar',
            'url' => '/horarios',
            'menu_id' => (Menu::where('nombre', 'Horarios')->first())->id
        ]);
        subMenu::create([
            'item' => 'Reporte Horarios',
            'icon' => 'simple-icon-info',
            'url' => '/reporte/horarios',
            'menu_id' => (Menu::where('nombre', 'Horarios')->first())->id
        ]);
        subMenu::create([
            'item' => 'Valid. Horas Extras',
            'icon' => 'simple-icon-check',
            'url' => '/horas_extras',
            'menu_id' => (Menu::where('nombre', 'Horarios')->first())->id
        ]);
        /******************************************************************************************************************* */
        subMenu::create([
            'item' => 'Ind. Novedades',
            'icon' => 'simple-icon-support',
            'url' => '/indicadores/novedades',
            'menu_id' => (Menu::where('nombre', 'Indicadores')->first())->id
        ]);

        subMenu::create([
            'item' => 'Ind. Llegada Tarde',
            'icon' => 'simple-icon-clock',
            'url' => '/indicadores/tiempo',
            'menu_id' => (Menu::where('nombre', 'Indicadores')->first())->id
        ]);
        /******************************************************************************************************************* */

        subMenu::create([
            'item' => 'Información General',
            'icon' => 'simple-icon-briefcase',
            'url' => '/general/empresa',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'C. de Costos',
            'icon' => 'simple-icon-home',
            'url' => '/centros_costos',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Dependencias',
            'icon' => 'simple-icon-star',
            'url' => '/dependencias',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Cargos',
            'icon' => 'simple-icon-tag',
            'url' => '/cargos',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);

        subMenu::create([
            'item' => 'Tipos de Contrato',
            'icon' => 'simple-icon-layers',
            'url' => '/contratos',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Funcionarios',
            'icon' => 'simple-icon-people',
            'url' => '/funcionarios',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Eps',
            'icon' => 'simple-icon-shield',
            'url' => '/eps',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Cajas de Comp.',
            'icon' => 'simple-icon-present',
            'url' => '/compensaciones',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Fondos Cesantías',
            'icon' => 'simple-icon-credit-card',
            'url' => '/cesantias',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Fondos Pensiones',
            'icon' => 'simple-icon-eyeglass',
            'url' => '/pensiones',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Parametrización',
            'icon' => 'simple-icon-list',
            'url' => '/parametrizacion',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Encuestas',
            'icon' => 'iconsmind-Check',
            'url' => '/encuestas',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
        subMenu::create([
            'item' => 'Formatos',
            'icon' => 'simple-icon-docs',
            'url' => '/formatos',
            'menu_id' => (Menu::where('nombre', 'Configuracion')->first()->id)
        ]);
    }
}
