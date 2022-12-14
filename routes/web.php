<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\Modulo_padreController;
use App\Http\Controllers\AccesosController;
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PersonaController;

//--------SGC
use App\Http\Controllers\sgc\DocumentoController;
use App\Http\Controllers\sgc\Ficha_indicador_unoController;
use App\Http\Controllers\sgc\Proceso_ceroController;
use App\Http\Controllers\sgc\Proceso_unoController;
use App\Http\Controllers\sgc\Proceso_dosController;
use App\Http\Controllers\sgc\Tipo_procesoController;
use App\Http\Controllers\sgc\ResolucionController;
USE App\Http\Controllers\sgc\Tipo_entidadController;
//-------COMISIONES


use App\Http\Controllers\sgc\EntidadController;
use App\Http\Controllers\sgc\Ficha_indicador_procedimientoController;
use App\Http\Controllers\sgc\ProcedimientoController;

use App\Http\Controllers\comisiones\ComisionController;
use App\Models\SGCProceso_cero;
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
Route::get('/', function () {
    return view('welcome');
})->name('web');

//--------------------------------------------------------------------------------------------------- Error
// 404
Route::get('/404', function () {
    return view('errors/404');
})->name('404');


Route::group(["middleware" => ['auth']], function () {
    //------------------------------------------------------------------------------------------------ Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //------------------------------------------------------------------------------------------------ Tema
    Route::get('/tema/{actual}', [HomeController::class, 'tema'])->name('tema');

    //------------------------------------------------------------------------------------------------ Modulo
    Route::resource('modulo', ModuloController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('modulo/grilla', [ModuloController::class, 'grilla'])->name('modulo.grilla');
    Route::get('modulo/get_modulos', [ModuloController::class, 'get_modulos'])->name('modulo.get_modulos');

    //------------------------------------------------------------------------------------------------ Modulo padre
    Route::resource('modulo_padre', Modulo_padreController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('modulo_padre/grilla', [Modulo_padreController::class, 'grilla'])->name('modulo_padre.grilla');

    //------------------------------------------------------------------------------------------------ Accesos
    Route::resource('accesos', AccesosController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('accesos/acceso', [AccesosController::class, 'acceso'])->name('accesos.acceso');

    //------------------------------------------------------------------------------------------------ Funcion
    Route::resource('funcion', FuncionController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('funcion/grilla', [FuncionController::class, 'grilla'])->name('funcion.grilla');

    //------------------------------------------------------------------------------------------------ Usuario
    Route::resource('usuario', UsuarioController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('usuario/grilla', [UsuarioController::class, 'grilla'])->name('usuario.grilla');
    Route::get('usuario/{id}', [UsuarioController::class, 'reset'])->name('usuario.reset');
    Route::post('usuario/store_reset', [UsuarioController::class, 'store_reset'])->name('usuario.store_reset');

    //------------------------------------------------------------------------------------------------ Role
    Route::resource('role', RoleController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('role/grilla', [RoleController::class, 'grilla'])->name('role.grilla');

    //------------------------------------------------------------------------------------------------ Persona
    Route::get('persona/buscar/{search}', [PersonaController::class, 'buscar'])->name('persona.buscar');



    //!-------------------------------SGC-------------------------------//


    //--------------------------------------------------------------------------------------------------- ENTIDAD


    //---------------------------------------------------------------------------------------------------TIPOS DE PROCESO
    Route::resource('tipo_proceso', Tipo_procesoController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('tipo_proceso/grilla', [Tipo_procesoController::class, 'grilla'])->name('tipo_proceso.grilla');
    Route::post('tipo_proceso/aprobar', [Tipo_procesoController::class, 'aprobar'])->name('tipo_proceso.aprobar');
    Route::get('tipo_proceso_ver/{id}', [Tipo_procesoController::class, 'ver'])->name('tipo_proceso.ver');

    //----------------------------------------------------------------------------------------------------PROCESO NIVEL CERO
    Route::resource('proceso_cero', Proceso_ceroController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('proceso_cero/grilla', [Proceso_ceroController::class, 'grilla'])->name('proceso_cero.grilla');
    Route::post('proceso_cero/aprobar', [Proceso_ceroController::class, 'aprobar'])->name('proceso_cero.aprobar');
    Route::get('proceso_cero_ver/{id}', [Proceso_ceroController::class, 'ver'])->name('proceso_cero.ver');

    //----------------------------------------------------------------------------------------------------PROCESO NIVEL UNO
    Route::resource('proceso_uno', Proceso_unoController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('proceso_uno/grilla', [Proceso_unoController::class, 'grilla'])->name('proceso_uno.grilla');
    Route::post('proceso_uno/aprobar', [Proceso_unoController::class, 'aprobar'])->name('proceso_uno.aprobar');
    Route::get('proceso_uno_ver/{id}', [Proceso_unoController::class, 'ver'])->name('proceso_uno.ver');


    //----------------------------------------------------------------------------------------------------PROCESO NIVEL UNO
    Route::resource('procedimiento', ProcedimientoController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('procedimiento/grilla', [ProcedimientoController::class, 'grilla'])->name('procedimiento.grilla');
    Route::post('procedimiento/aprobar', [ProcedimientoController::class, 'aprobar'])->name('procedimiento.aprobar');
    Route::get('procedimiento_ver/{id}', [ProcedimientoController::class, 'ver'])->name('procedimiento.ver');

    //-----------------------------------------------------------------------------------------------------INDICADORES NIVEL UNO
    Route::resource('ficha_indicador_uno', Ficha_indicador_unoController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('ficha_indicador_uno/grilla/', [Ficha_indicador_unoController::class, 'grilla'])->name('ficha_indicador_uno.grilla');
    Route::post('ficha_indicador_uno/aprobar', [Ficha_indicador_unoController::class, 'aprobar'])->name('ficha_indicador_uno.aprobar');
    Route::get('ficha_indicador_uno_ver/{id}', [Ficha_indicador_unoController::class, 'ver'])->name('ficha_indicador_uno.ver');

    //-----------------------------------------------------------------------------------------------------INDICADORES NIVEL DOS
    Route::resource('ficha_indicador_procedimiento', Ficha_indicador_procedimientoController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('ficha_indicador_procedimiento/grilla/', [Ficha_indicador_procedimientoController::class, 'grilla'])->name('ficha_indicador_procedimiento.grilla');
    Route::post('ficha_indicador_procedimiento/aprobar', [Ficha_indicador_procedimientoController::class, 'aprobar'])->name('ficha_indicador_procedimiento.aprobar');
    Route::get('ficha_indicador_procedimiento_ver/{id}', [Ficha_indicador_procedimientoController::class, 'ver'])->name('ficha_indicador_procedimiento.ver');

    //------------------------------------------------------------------------------------------------------DOCUMENTOS
    Route::resource('documentos', DocumentoController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('documentos/grilla/', [DocumentoController::class, 'grilla'])->name('documentos.grilla');
    Route::post('documentos/aprobar', [DocumentoController::class, 'aprobar'])->name('documentos.aprobar');
    Route::get('documentos/{id}', [DocumentoController::class, 'ver'])->name('documentos.ver');

    //------------------------------------------------------------------------------------------------------RESOLUCIONES
    Route::resource('resoluciones', ResolucionController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('resoluciones/grilla/', [ResolucionController::class, 'grilla'])->name('resoluciones.grilla');
    Route::post('resoluciones/aprobar', [ResolucionController::class, 'aprobar'])->name('resoluciones.aprobar');
    Route::get('resoluciones_ver/{id}', [ResolucionController::class, 'ver'])->name('resoluciones.ver');    

    //------------------------------------------------------------------------------------------------------TIPOS ENTIDAD
    Route::resource('tipo_entidad', Tipo_entidadController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('tipo_entidad/grilla/', [Tipo_entidadController::class, 'grilla'])->name('tipo_entidad.grilla');
    Route::post('tipo_entidad/aprobar', [Tipo_entidadController::class, 'aprobar'])->name('tipo_entidad.aprobar');
    Route::get('tipo_entidad_ver/{id}', [Tipo_entidadController::class, 'ver'])->name('tipo_entidad.ver');

    //------------------------------------------------------------------------------------------------------ENTIDAD
    Route::resource('entidad', EntidadController::class)->only("index", "create", "store", "edit", "destroy");
    Route::get('entidad/grilla/', [EntidadController::class, 'grilla'])->name('entidad.grilla');
    Route::post('entidad/aprobar', [EntidadController::class, 'aprobar'])->name('entidad.aprobar');
    Route::get('entidad_ver/{id}', [EntidadController::class, 'ver'])->name('entidad.ver');
    
     //-----------------------------------------------------------------------------------------------------COMISIONES
     Route::resource('comision', ComisionController::class)->only('index', 'create', 'store', 'edit', 'destroy');
     Route::get('comision/grilla', [ComisionController::class, 'grilla'])->name('comision.grilla');




     //--------REPORTE SGC
     Route::get('/inventario_procesos', function (Codedge\Fpdf\Fpdf\Fpdf $fpdf) {
        $procesos_cero = SGCProceso_cero::with('procesos_uno')->with('tipo_proceso')->where('idestado', 2)->get();

        // Variables 
        $h      = 3;
        $l      = 0;
        $x      = 4;
        $y      = 0;
        $total  = 0;


        $fpdf->AddPage();
        $fpdf->SetTitle('Inventario de Procesos');
        $fpdf->AliasNbPages();
		$fpdf->SetLeftMargin($x);
        $fpdf->setFillColor(249, 249, 249);
        $fpdf->SetDrawColor(204, 204, 204);

        //HEADER
        $fpdf->SetTextColor(0,0,0);
        $fpdf->setFont("Arial", "B", "12");
        $fpdf->SetX($x);
        $fpdf->Cell(201,$h+2, utf8_decode("INVENTARIO DE PROCESOS"), 0, 1, "C");

        $y += 30;
        $fpdf->SetXY($x,$y);
        $fpdf->setFont("Arial", "", "9");
        $fpdf->SetX($x + 160);
        $y += 12;
        $fpdf->SetXY($x,$y);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(30,$h,utf8_decode('Facultad de Ingenier??a de Sistemas e Inform??tica'),0,0,'L');
        $fpdf->setFont("Arial", "", "9");
        $fpdf->SetXY($x+30,$y);
        $fpdf->Cell(100,$h,'',0,1,'L');

        // END header


        // Cabecera tabla
        $Dim = array('0'=>30,'1'=>30,'2'=>110,'3'=>30);
        $y += 5;
        $fpdf->SetXY($x,$y);
        $fpdf->SetFont('Arial','B',10);
		$fpdf->Cell($Dim[0],$h+6,utf8_decode("Codigo"),1,0, 'C', false);
        $fpdf->Cell($Dim[1],$h+6,utf8_decode("Proceso Nivel 0"),1,0, 'C', false);
        $fpdf->Cell($Dim[2],$h+6,utf8_decode("Codigo"),1,0, 'C', false);
        $fpdf->Cell($Dim[3],$h+6,utf8_decode("Proceso Nivel 1"),1,1, 'C', false);
        
        // Detalle tabla
        foreach ($procesos_cero as $key => $value) {
            $total += round($value->subtotal,2);
            $fpdf->SetFont('Arial','',8);
            $fpdf->Cell($Dim[0],$h+2,$value->codigo,1,0,"C");
            $fpdf->Cell($Dim[1],$h+2,$value->descripcion,1,0,"C");
            $fpdf->Cell($Dim[2],$h+2,$value->codigo,1,0,"L");
            $fpdf->Cell($Dim[3],$h+2,$value->descripcion,1,1, "R");
        }
       
        $fpdf->Output();
        exit;
    
    });


});
