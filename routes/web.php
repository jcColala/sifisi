<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\Modulo_padreController;
use App\Http\Controllers\AccesosController;
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\sgc\DocumentoController;
use App\Http\Controllers\sgc\EntidadController;
use App\Http\Controllers\sgc\IndicadorController;
use App\Http\Controllers\sgc\Proceso_ceroController;
use App\Http\Controllers\sgc\Proceso_unoController;
use App\Http\Controllers\sgc\Proceso_unodetalleController;
use App\Http\Controllers\sgc\Tipo_procesoController;
use App\Http\Controllers\sgc\FichaIndicadorController;
use App\Http\Controllers\sgc\ResolucionController;
use App\Models\Proceso_cero;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;

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
Route::get('/404', function () {return view('errors/404');})->name('404');


Route::group(["middleware"=>['auth']], function(){
    //------------------------------------------------------------------------------------------------ Home
    Route::get('/home', [HomeController::class,'index'])->name('home');

    //------------------------------------------------------------------------------------------------ Tema
    Route::get('/tema/{actual}', [HomeController::class,'tema'])->name('tema');

    //------------------------------------------------------------------------------------------------ Modulo
    Route::resource('modulo', ModuloController::class)->only("index","create", "store","edit", "destroy");
    Route::get('modulo/grilla',[ModuloController::class, 'grilla'])->name('modulo.grilla');
    Route::get('modulo/get_modulos',[ModuloController::class, 'get_modulos'])->name('modulo.get_modulos');

    //------------------------------------------------------------------------------------------------ Modulo padre
    Route::resource('modulo_padre', Modulo_padreController::class)->only("index","create", "store","edit", "destroy");
    Route::get('modulo_padre/grilla',[Modulo_padreController::class, 'grilla'])->name('modulo_padre.grilla');

    //------------------------------------------------------------------------------------------------ Accesos
    Route::resource('accesos', AccesosController::class)->only("index","create", "store","edit", "destroy");
    Route::get('accesos/acceso',[AccesosController::class, 'acceso'])->name('accesos.acceso');

    //------------------------------------------------------------------------------------------------ Funcion
    Route::resource('funcion', FuncionController::class)->only("index","create", "store","edit", "destroy");
    Route::get('funcion/grilla',[FuncionController::class, 'grilla'])->name('funcion.grilla');

    //------------------------------------------------------------------------------------------------ Usuario
    Route::resource('usuario', UsuarioController::class)->only("index","create", "store","edit", "destroy");
    Route::get('usuario/grilla',[UsuarioController::class, 'grilla'])->name('usuario.grilla');
    Route::get('usuario/{id}',[UsuarioController::class, 'reset'])->name('usuario.reset');
    Route::post('usuario/store_reset',[UsuarioController::class, 'store_reset'])->name('usuario.store_reset');

    //------------------------------------------------------------------------------------------------ Role
    Route::resource('role', RoleController::class)->only("index","create", "store","edit", "destroy");
    Route::get('role/grilla',[RoleController::class, 'grilla'])->name('role.grilla');

    //------------------------------------------------------------------------------------------------ Persona
    Route::get('persona/buscar/{search}',[PersonaController::class, 'buscar'])->name('persona.buscar');



    //!-------------------------------SGC-------------------------------//

    
    //--------------------------------------------------------------------------------------------------- ENTIDAD
    Route::resource('entidad', EntidadController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('entidad/grilla',[EntidadController::class, 'grilla'])->name('entidad.grilla');
    Route::post('entidad/aprobar ',[EntidadController::class, 'aprobar'])->name('entidad.aprobar');
    Route::get('entidad/{id}',[EntidadController::class, 'ver'])->name('entidad.ver');
    
    //---------------------------------------------------------------------------------------------------TIPOS DE PROCESO
    Route::resource('tipo_proceso', Tipo_procesoController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('tipo_proceso/grilla',[Tipo_procesoController::class, 'grilla'])->name('tipo_proceso.grilla');
    Route::post('tipo_proceso/aprobar',[Tipo_procesoController::class, 'aprobar'])->name('tipo_proceso.aprobar');
    Route::get('tipo_proceso_ver/{id}',[Tipo_procesoController::class, 'ver'])->name('tipo_proceso.ver');

    //----------------------------------------------------------------------------------------------------PROCESO NIVEL CERO
    Route::resource('proceso_cero', Proceso_ceroController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('proceso_cero/grilla',[Proceso_ceroController::class, 'grilla'])->name('proceso_cero.grilla');
    Route::post('proceso_cero/aprobar',[Proceso_ceroController::class, 'aprobar'])->name('proceso_cero.aprobar');
    Route::get('proceso_cero_ver/{id}',[Proceso_ceroController::class, 'ver'])->name('proceso_cero.ver');

    //----------------------------------------------------------------------------------------------------PROCESO NIVEL UNO
    Route::resource('proceso_uno', Proceso_unoController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('proceso_uno/grilla',[Proceso_unoController::class, 'grilla'])->name('proceso_uno.grilla');
    Route::post('proceso_uno/aprobar',[Proceso_unoController::class, 'aprobar'])->name('proceso_uno.aprobar');
    Route::get('proceso_uno_ver/{id}',[Proceso_unoController::class, 'ver'])->name('proceso_uno.ver');

    //-----------------------------------------------------------------------------------------------------INDICADORES
    Route::resource('indicador', IndicadorController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('indicador/grilla/',[IndicadorController::class, 'grilla'])->name('indicador.grilla');
    Route::post('indicador/aprobar',[IndicadorController::class, 'aprobar'])->name('indicador.aprobar');
    Route::get('indicador_ver/{id}',[IndicadorController::class, 'ver'])->name('indicador.ver');

    //------------------------------------------------------------------------------------------------------DOCUMENTOS
    Route::resource('documentos', DocumentoController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('documentos/grilla/',[DocumentoController::class, 'grilla'])->name('documentos.grilla');
    Route::post('documentos/aprobar',[DocumentoController::class, 'aprobar'])->name('documentos.aprobar');
    Route::get('documentos/{id}',[DocumentoController::class, 'ver'])->name('documentos.ver');

    //------------------------------------------------------------------------------------------------------RESOLUCIONES
    Route::resource('resoluciones', ResolucionController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('resoluciones/grilla/',[ResolucionController::class, 'grilla'])->name('resoluciones.grilla');
    Route::post('resoluciones/aprobar', [ResolucionController::class, 'aprobar'])->name('resoluciones.aprobar');
    Route::get('resoluciones_ver/{id}',[ResolucionController::class, 'ver'])->name('resoluciones.ver');
    
});