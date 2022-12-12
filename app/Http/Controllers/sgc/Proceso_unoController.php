<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;

use App\Models\MOVSGCMov_proceso_uno;
use App\Models\SGCEntidad;
use App\Models\SGCProceso_cero;
use App\Models\SGCProceso_uno;
use App\Models\SGCTipo_proceso;
use App\Models\SGCIndicador;
use App\Models\MOVSGCMov_indicador;

use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;  
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class Proceso_unoController extends Controller
{
    public $modulo                  = "Procesos de Nivel 1";
    public $path_controller         = "proceso_uno";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new SGCProceso_uno();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["proceso_cero"]      = SGCProceso_cero::get();
        $datos["entidades"]         = SGCEntidad::get();
        $datos["tipo_proceso"]      = SGCTipo_proceso::get();
        $datos["data"]              = [];
        $datos["indicadores"]       = [];

        if( $id != null )
            $datos["data"]          = SGCProceso_uno::withTrashed()->find($id);   
        if($id != null)
            $datos["indicadores"]   = SGCIndicador::where('idproceso_uno', $id)->where('version', $datos["data"]->version)->get();     
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        //withTrashed
        $objeto = SGCProceso_uno::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->orderBy('id', 'ASC')->get();

        return DataTables::of($objeto)
                ->addIndexColumn()
                ->addColumn("icono", function($objeto){
                    return "<i class='{$objeto->icono}'></i>";
                })
                ->addColumn("activo", function($row){
                    return (is_null($row->deleted_at))?'<span class="dot-label bg-success" data-toggle="tooltip" data-placement="top" title="Activo"></span>':'<span class="dot-label bg-danger" data-toggle="tooltip" data-placement="top" title="Inactivo"></span>';
                })
                ->rawColumns(['icono', "activo"])
                ->make(true);
    }

    public function create(){
        return view("{$this->path_controller}.form",$this->form());
    }

    public function store(Request $request){
        $this->validate($request,[
            'idproceso_cero'=>'required',
            'idelaborado'=>'required',
            'idrevisado'=>'required',
            'idaprobado'=>'required',
            'codigo'=> 'required',
            'descripcion' => 'required',
            'version'=>'required',
            'fecha_aprobado'=>'required',
            'proveedores'=>'required',
            'entradas'=>'required',
            'salidas'=>'required',
            'clientes'=>'required',
            'codigo_indicador'=>'required',
            'descripcion_indicador'=>'required',

            ],[
            'idproceso_cero.required' => 'Seleccione el Proceso Nivel Cero al que pertenece este Proceso Nivel 1',
            'idelaborado.required' => 'Seleccione quien elaboró el proceso',
            'idrevisado.required' => 'Seleccione quien revisó el proceso',
            'idaprobado.required' => 'Seleccione quien aprobó el proceso',
            'codigo.required'=> 'Escriba el código del proceso',
            'descripcion.required' => 'Escriba el Nombre del Proceso',
            'version.required' => 'Escriba la versión del documento',
            'fecha_aprobado.required' => 'Seleccione la fecha en la que se aprobó el documento',
            'proveedores.required' => 'Escriba los proveedores del Proceso',
            'entradas.required' => 'Escriba las entradas del Proceso',
            'salidas.required' => 'Escriba las salidas del Proceso',
            'clientes.required' => 'Escriba los clientes del Proceso',
            'codigo_indicador.required' => 'Escriba los clientes del Proceso',
            'descripcion_indicador.required' => 'Escriba los clientes del Proceso',
        ]);

        return DB::transaction(function() use ($request){
            //LLENADO - EDICIÓN EN LA TABLA MOVIMIENTOS
            /*$obj_mov        = MOVSGCMov_proceso_uno::withTrashed()->find($request->id);

            if(is_null($obj_mov))
                $obj_mov    = new MOVSGCMov_proceso_uno();
            $obj_mov->fill($request->all());
            $obj_mov->save();*/

            //LLENADO - EDICIÓN EN LA TABLA SGC
            $obj        = SGCProceso_uno::withTrashed()->find($request->id);
            if(empty($obj))
            {
                $obj    = new SGCProceso_uno();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->version = $request->version;
                $obj->fecha_aprobado = $request->fecha_aprobado;
                $obj->idproceso_cero = $request->idproceso_cero;
                $obj->codigo = $request->codigo;
                $obj->descripcion = $request->descripcion;
                $obj->proveedores = $request->proveedores;
                $obj->entradas = $request->entradas;
                $obj->salidas  = $request->salidas;
                $obj->clientes = $request->clientes;
                $obj->idelaborado = $request->idelaborado;
                $obj->idrevisado  = $request->idrevisado;
                $obj->idaprobado  = $request->idaprobado;
                $obj->save();
            }else{
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->version = $request->version;
                $obj->fecha_aprobado = $request->fecha_aprobado;
                $obj->idproceso_cero = $request->idproceso_cero;
                $obj->codigo = $request->codigo;
                $obj->descripcion = $request->descripcion;
                $obj->proveedores = $request->proveedores;
                $obj->entradas = $request->entradas;
                $obj->salidas  = $request->salidas;
                $obj->clientes = $request->clientes;
                $obj->idelaborado = $request->idelaborado;
                $obj->idrevisado  = $request->idrevisado;
                $obj->idaprobado  = $request->idaprobado;
                $obj->save();
            }
                
            //!INDICADORES
            //movimiento
            /*for ($i=0; $i < count($request->codigo_indicador); $i++) { 
                $indicador_mov  = MOVSGCMov_indicador::where('codigo',$request->codigo_indicador[$i])->first();
                
                if(is_null($indicador_mov))
                    $indicador_mov = new MOVSGCMov_indicador();
                $indicador_mov->idproceso_uno = $obj->id;
                $indicador_mov->idpersona_solicita = $request->idpersona_solicita;
                $indicador_mov->codigo = $request->codigo_indicador[$i];
                $indicador_mov->descripcion = $request->descripcion_indicador[$i];
                $indicador_mov->version = $request->version;
                $indicador_mov->save();
            }*/

            //sgc
            for ($i=0; $i < count($request->codigo_indicador); $i++){ 
                $indicador  = SGCIndicador::where('codigo',$request->codigo_indicador[$i])->first();
                
                if(is_null($indicador))
                    $indicador = new SGCIndicador();
                $indicador->idproceso_uno = $obj->id;
                $indicador->idpersona_solicita = $request->idpersona_solicita;
                $indicador->codigo = $request->codigo_indicador[$i];
                $indicador->descripcion = $request->descripcion_indicador[$i];
                $indicador->version = $request->version;
                $indicador->save();
            }
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        $obj = SGCProceso_uno::withTrashed()->where("id",$request->id)->first();
        /*if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel 1 ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }*/

        if($request->accion = "aprobar"){
            $obj->idpersona_aprueba = auth()->user()->persona->id;
            $obj->idestado = 2;
            $obj->save();

            return response()->json($obj);

        }
        if ($request->accion == "eliminar") {
            SGCProceso_uno::find($request->id)->delete();
            return response()->json();
        }
        SGCProceso_uno::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
