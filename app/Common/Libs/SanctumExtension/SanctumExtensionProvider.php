<?php

namespace App\Common\Libs\SanctumExtension;

use App\Common\Libs\SanctumExtension\Listeners\TokenAuthenticatedListener;
use App\Common\Libs\SanctumExtension\Middleware\TokenRefreshAuthenticate;
use App\Http\Middleware\Authenticate;
use Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Events\TokenAuthenticated;

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
        Event::listen(
            TokenAuthenticated::class,
            [TokenAuthenticatedListener::class, 'handle']
        );
    }
}
