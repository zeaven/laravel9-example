<?php

namespace App\Common\Libs\SanctumExtension;

use App\Common\Libs\SanctumExtension\Middleware\TokenRefreshAuthenticate;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\ServiceProvider;

class SanctumExtensionProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(common_path('Libs/SanctumExtension/sanctum.php'), 'sanctum');

        $this->app->bind(Authenticate::class, function ($app) {
            return new TokenRefreshAuthenticate($app['auth']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public function boot()
    {
        // TODO: Implement booted() method.
    }
}
