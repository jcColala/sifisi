<?php

namespace App\Providers;

use App\Models\Modulo;
use App\Models\Modulo_padre;
use App\Models\Funcion;

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

        View::composer(['extras.botones'],function($view){
            $view->with('funcion', Funcion::where("boton","S")->orderBy("orden","ASC")->get());
        });
    }
}
