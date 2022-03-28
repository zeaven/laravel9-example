<?php

namespace App\Common\Libs\Validators;

use App\Common\Libs\Validators\MbMaxValidator;
use App\Common\Libs\Validators\MobileValidator;
use App\Common\Libs\Validators\ValidatorExtension;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        ValidatorExtension::add(MbMaxValidator::class);
        ValidatorExtension::add(IdCardValidator::class);
        ValidatorExtension::add(MobileValidator::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
