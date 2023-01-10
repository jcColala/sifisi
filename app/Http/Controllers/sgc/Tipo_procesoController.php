<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;

use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

/** ---- MODELS */
use App\Models\SGCTipo_proceso;
use App\Models\MOVSGCMov_tipo_proceso;

class Tipo_procesoController extends Controller
{
    public $modulo                  = "Tipos de Procesos";
    public $path_controller         = "tipo_proceso";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }
        $this->model                = new SGCTipo_proceso();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();
    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["data"]              = [];
        if( $id != null )
            $datos["data"]          = SGCTipo_proceso::withTrashed()->find($id);

        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        $objeto = SGCTipo_proceso::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->orderBy('id', 'asc')->withTrashed();
        
        
        return DataTables::of($objeto)
                ->addIndexColumn()
                ->addColumn("icono", function($objeto){
                    return "<i class='{$objeto->icono}'></i>";
                })
                ->addColumn("activo", function($row){
                    return (is_null($row->deleted_at))?'<span class="dot-label bg-success" data-toggle="tooltip" data-placement="top" title="Activo"></span>':'<span class="dot-label bg-danger" data-toggle="tooltip" data-placement="top" title="Inactivo"></span>';
                })->addColumn('estado', function($objeto){
                    return $objeto->tipo_accion->descripcion." ".$objeto->estado->descripcion;
                })
                ->rawColumns(
                    ['icono', "activo", "estado"]
                    )
                ->make(true);
    }

    public function create(){
        return view("{$this->path_controller}.form",$this->form());
    }

    public function store(Request $request){

        $this->validate($request,[
            'codigo'=> 'required',
            'descripcion' => 'required',
            ],[
            'codigo'=> 'Escriba el código del Tipo de Proceso',
            'descripcion' => 'Escriba el Nombre del Tipo de Proceso',
        ]);

        return DB::transaction(function() use ($request){
            $obj = SGCTipo_proceso::withTrashed()->find($request->id);

            /**------VALIDA SI NO EXISTE PARA REGISTRAR */
            if(empty($obj)){
                $obj = new SGCTipo_proceso();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->codigo = $request->codigo;
                $obj->descripcion = $request->descripcion;
                $obj->save();

                return response()->json($obj);

            }

            /**---------VALIDA SI ESTA PENDIENTE */
            if($obj->idestado == 1){
                $data = array(
                    "type" => "error",
                    "text" => "No puedes editar un registro que está en estado Pendiente"
                );
                return response()->json($data);
            }
            /**-----------EDITA EL REGISTRO */
            $obj->idpersona_solicita = $request->idpersona_solicita;
            $obj->idpersona_aprueba = null;
            $obj->idtipo_accion = 2;
            $obj->idestado = 1;
            $obj->codigo = $request->codigo;
            $obj->descripcion = $request->descripcion;
            $obj->save();              
            
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function ver($id){ 
        return view("{$this->path_controller}.form_disabled",$this->form($id));
    }

    public function aprobar(request $request){
        return DB::transaction(function () use($request){
            $obj = SGCTipo_proceso::withTrashed()->find($request->id);

            /**-----VALIDA EL ESTADO EN *PENDIENTE* */
            if($obj->idestado == 1){
                $obj->idpersona_aprueba = auth()->user()->persona->id;
                $obj->idestado = 2;
                $obj->save();
                        
                /**---------REGISTRRA EL MOVIMIENTO */
                $mov = new MOVSGCMov_tipo_proceso();
                $mov->idestado = $obj->idestado;
                $mov->idtipo_accion = $obj->idtipo_accion;
                $mov->idpersona_solicita = $obj->idpersona_solicita;
                $mov->idpersona_aprueba = $obj->idpersona_aprueba;
                $mov->idsgc = $obj->id;
                $mov->descripcion = $obj->descripcion;
                $mov->codigo = $obj->codigo;
                $mov->save();

                /**------ELIMINA EL REGISTRO */
                if($obj->idtipo_accion == 3)
                    $obj->delete();
                /**---------RESTAURA EL REGISTRO */
                if($obj->idtipo_accion == 4)
                    $obj->restore();

                return response()->json($obj);
            }
            return response()->json($obj);
        });
    }

    public function destroy(Request $request){

        $obj = SGCTipo_proceso::withTrashed()->find($request->id);

        /**-------VALIDA QUE EL ESTADO ESTE EN PENDIENTE */
        if($obj->idestado == 1){
            $data = array(
                "type" => "error",
                "text" => "No puedes ".$request->accion." un registro que está en estado Pendiente"
            );
            return response()->json($data);
        }

        /**------VALIDA QUE NO HAYA DATOS RELACIONADOS */
        if($obj->procesos_cero->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Tipo de Proceso ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }

        /**----------SOLICITUD DE ELIMINAR---- */
        if ($request->accion == "eliminar") {
            $obj->idpersona_solicita = auth()->user()->persona->id;
            $obj->idtipo_accion = 3;
            $obj->idestado = 1;
            $obj->save();

            return response()->json($obj);   
        }

        /**---------SOLICITUD DE RESTAURAR---- */
        $obj->idpersona_solicita = auth()->user()->persona->id;
        $obj->idtipo_accion = 4;
        $obj->idestado = 1;
        $obj->save();

        return response()->json($obj);   
    }
}
