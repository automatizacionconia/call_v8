<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $namespaceSeguridad = 'App\Http\Controllers\Api\Seguridad';
    protected $namespacePide= 'App\Http\Controllers\Api\Pide';
    protected $namespaceGeneral = 'App\Http\Controllers\Api\General';
    protected $namespaceCall= 'App\Http\Controllers\Api\Call';
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();

        $this->mapApiRoutes();

        $this->mapApiSeguridadRoutes();

        $this->mapApiPideRoutes();

        $this->mapApiGeneralRoutes();

        $this->mapApiCallRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapApiSeguridadRoutes()
    {
        Route::prefix('api/seguridad')
            ->middleware('api')
            ->namespace($this->namespaceSeguridad)
            ->group(function () {
                require base_path('routes/api/Seguridad/seguridad.php');
            });
    }

    protected function mapApiPideRoutes()
    {
        Route::prefix('api/pide')
            ->middleware('api')
            ->namespace($this->namespacePide)
            ->group(function () {
                require base_path('routes/api/Pide/pide.php');
            });
    }

    protected function mapApiGeneralRoutes()
    {
        Route::prefix('api/general')
            ->middleware('api')
            #->middleware('decrypt.claims')
            ->namespace($this->namespaceGeneral)
            ->group(function () {
                require base_path('routes/api/General/area.php');
            });
    }

    protected function mapApiCallRoutes()
    {
        Route::prefix('api/call')
            ->middleware('api')
            ->namespace($this->namespaceCall)
            ->group(function () {
                require base_path('routes/api/Call/agente.php');
                require base_path('routes/api/Call/cliente.php');
                require base_path('routes/api/Call/plataforma.php');
                require base_path('routes/api/Call/cartera.php');
                require base_path('routes/api/Call/grupo.php');
            });
    }
}
