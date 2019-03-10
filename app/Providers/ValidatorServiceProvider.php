<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Rules\RuleValidator;


class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $validator = new RuleValidator();
        foreach( $validator->getRules() as $key => $rule ) {
            $this->app['validator']->extend($key, sprintf("%s@validate", $rule ));
        }
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
