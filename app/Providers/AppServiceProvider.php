<?php

namespace App\Providers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Eps;
use App\Models\Funcionario;
use App\Observers\ClienteObserver;
use App\Observers\EmpresaObserver;
use App\Observers\funcionarioObserver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Funcionario::observe(funcionarioObserver::class);
        Cliente::observe(ClienteObserver::class);
        Empresa::observe(EmpresaObserver::class);

        Schema::defaultStringLength(191);

        //formato de moneda para el reporte pdf de la colilla y otros reportes de nómina
        Blade::directive('money', function ($money) {
            return "<?php echo '$' . number_format($money, 2); ?>";
        });

        //Settear a Carbo en español
        Carbon::setLocale(config('app.locale'));
    }
}
