<?php

namespace App\Providers;

use App\Http\Controllers\Api\RecursosHumanos\Asistencia\FaltasTardanza\Services\FaltasTardanzaServices;
use App\Http\Controllers\Api\RecursosHumanos\Asistencia\HorasExtra\Services\HorasExtraServices;
use App\Repositories\PersonaRepository;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(
        //     Repository::class,
        //     PersonaRepository::class
        // );
        // $this->app->singleton(HorasExtraServices::class, function () {
        //     return new HorasExtraServices();
        // });
        // $this->app->singleton(FaltasTardanzaServices::class, function () {
        //     return new FaltasTardanzaServices();
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('es');
        date_default_timezone_set('America/Lima');
        
        Schema::defaultStringLength(191);
    }
}
