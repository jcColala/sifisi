<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModuloController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//--------------------------------------------------------------------------------------------------- Web
Route::get('/', function () {return view('welcome');})->name('web');

//--------------------------------------------------------------------------------------------------- Error
// 404
Route::get('/404', function () {return view('error/404');})->name('404');
// 500
Route::get('/500', function () {return view('error/500');})->name('500');


Route::group(["middleware"=>"auth"], function(){
    //------------------------------------------------------------------------------------------------ Home
    Route::get('/home', [HomeController::class,'index'])->name('home');

    //------------------------------------------------------------------------------------------------ Home
    Route::get('/tema/{actual}', [HomeController::class,'tema'])->name('tema');

    //------------------------------------------------------------------------------------------------ Modulos
    Route::resource('modulo', ModuloController::class)->only("index", "store", "edit", "destroy");
    Route::get('modulo/grilla',[ModuloController::class, 'grilla'])->name('modulo.grilla');
});