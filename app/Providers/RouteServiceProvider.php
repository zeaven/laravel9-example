<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    protected $namespace = 'App\\Http\\Controllers';

    /**
     * 自定义限速中间件
     */
    public $bindings = [
        // 'throttle' => \App\Http\Middleware\ExThrottleRequests::class,
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->configRoute('api', 'api');
            $this->configRoute('web');
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function configRoute(string $name, string $prefix = '/', array $middleware = [])
    {
        $namespace = $this->namespace . "\\" . ucfirst($name);
        Route::prefix($prefix)
            ->middleware(empty($middleware) ? $name : $middleware)
            ->namespace($namespace)
            ->domain(config('app.url'))
            ->group(base_path("routes/{$name}.php"));
    }
}
