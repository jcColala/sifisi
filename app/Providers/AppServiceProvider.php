<?php

namespace App\Providers;

use App\Models\Modulo;
use App\Models\Modulo_padre;

use Illuminate\Support\Facades\View;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){

        View::composer(['layouts.sidebar'],function($view){
            $view->with('menu', (new Modulo_padre)->menu());
        });
    }
}
