<?php

namespace AlgoWeb\PODataLaravel\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MetadataRouteProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        self::setupRoute();
    }

    private static function setupRoute()
    {
      //  $auth_middleware = self::getAuthMiddleware();
        $controllerMethod = 'AlgoWeb\PODataLaravel\Controllers\ODataController@index';
        Route::any('v1/odata.svc/{section}', ['uses' => $controllerMethod])
            ->where(['section' => '.*']);
        Route::any('v1/odata.svc', ['uses' => $controllerMethod]);
        Route::any('v1/$metadata', ['uses' => $controllerMethod]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

    private static function getAuthMiddleware()
    {
        $auth_middleware = 'auth.basic';

        if (interface_exists(\Illuminate\Contracts\Auth\Factory::class)) {
            $manager = App::make(\Illuminate\Contracts\Auth\Factory::class);
            $auth_middleware = $manager->guard('api') ? 'auth:api' : $auth_middleware;
        }
        return $auth_middleware;
    }
}
