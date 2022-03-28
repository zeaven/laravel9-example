<?php

namespace App\Providers;

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
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        if (!$this->app->isProduction()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        //修复json系列化小数点溢出
        ini_set('serialize_precision', 14);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->isProduction()) {
            app('debugbar')->enable();
        }
    }
}
