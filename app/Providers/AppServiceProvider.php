<?php

namespace App\Providers;

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
        Schema::defaultStringLength(191);

        //formato de moneda para el reporte pdf de la colilla y otros reportes de nómina
        Blade::directive('money', function ($money) {
            return "<?php echo '$' . number_format($money, 2); ?>";
        });

        //Settear a Carbo en español
        Carbon::setLocale(config('app.locale'));
    }
}
