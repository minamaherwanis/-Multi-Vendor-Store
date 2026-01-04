<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class GateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach (config('abilities') as $code => $label) {
                Gate::define($code,function($user) use($code){
            return $user->hasAbility($code);
            
        });   
        }


    }
}
