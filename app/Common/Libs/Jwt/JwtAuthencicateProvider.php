<?php

namespace App\Common\Libs\Jwt;

use App\Common\Libs\Jwt\AutoRefreshJwtAuth;
// use Tymon\JWTAuth\Http\Middleware\Authenticate;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\ServiceProvider;

class JwtAuthencicateProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Authenticate::class, function ($app) {
            return new AutoRefreshJwtAuth($app['auth']);
        });
    }
}
