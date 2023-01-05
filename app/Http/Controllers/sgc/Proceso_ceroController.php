<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;

use App\Models\SGCProceso_cero;
use App\Models\MOVSGCMov_proceso_cero;

use App\Models\SGCTipo_proceso;
use App\Models\Funcion;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class Proceso_ceroController extends Controller
{
    public $modulo                  = "Procesos de Nivel Cero";
    public $path_controller         = "proceso_cero";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }
        $this->model                = new SGCProceso_cero();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["tipo_proceso"]      = SGCTipo_proceso::where('idestado', 2)->with('procesos_cero')->get();
        $datos["data"]              = [];
        if( $id != null )
            $datos["data"]          = SGCProceso_cero::withTrashed()->find($id);

        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        //withTrashed
        $objeto = SGCProceso_cero::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->orderBy('id', 'ASC')->withTrashed();

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
            'idtipo_proceso'=>'required',
            'descripcion' => 'required',
            ],[
            'idtipo_proceso.required' => 'Seleccione el tipo de proceso',
            'descripcion.required' => 'Escriba el Nombre del Proceso',
        ]);
        return DB::transaction(function() use ($request){
            $obj        = SGCProceso_cero::withTrashed()->find($request->id);

            if(empty($obj)){//SI ESTA VACIO REGISTRA
                //REGISTRO EN TABLA
                $obj = new SGCProceso_cero();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->idtipo_accion = 1;
                $obj->idtipo_proceso = $request->idtipo_proceso;
                $obj->codigo = $request->codigo_hidde;
                $obj->descripcion = $request->descripcion;
                $obj->save();

                //REGISTRO MOVIMIENTOS
                $obj_mov = new MOVSGCMov_proceso_cero();
                $obj_mov->idpersona_solicita = $request->idpersona_solicita;
                $obj_mov->idtipo_accion = 1;
                $obj_mov->idsgc = $obj->id;
                $obj_mov->idtipo_proceso = $request->idtipo_proceso;
                $obj_mov->codigo = $request->codigo_hidde;
                $obj_mov->descripcion = $request->descripcion;
                $obj_mov->save();
            }else{
                if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
                    $data = array(
                        "type" => "error",
                        "text" => "No puedes editar un registro que está en estado Pendiente"
                    );
                    return response()->json($data);
                }
                //EDICIÓN TABLA
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->idpersona_aprueba = null;
                $obj->idtipo_accion = 2;
                $obj->idestado = 1;
                $obj->save();

                //EDICIÓN EN MOVIMIENTO
                $obj_mov = new MOVSGCMov_proceso_cero();
                $obj_mov->idpersona_solicita = $request->idpersona_solicita;
                $obj_mov->idtipo_accion = 2;
                $obj_mov->idsgc = $obj->id;
                $obj_mov->idtipo_proceso = $request->idtipo_proceso;
                $obj_mov->codigo = $request->codigo_hidde;
                $obj_mov->descripcion = $request->descripcion;
                $obj_mov->save();
            }
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
            //EDITA EL MOVIMIENTO
            $mov = MOVSGCMov_proceso_cero::where('idsgc', $request->id)->latest('created_at')->first();

            //SI EL ESTADO NO ESTA EN PENDIENTE NO HACE NADA
            if($mov->idestado == 2){
                return response()->json($mov);
            }
            
            $mov->idpersona_aprueba = auth()->user()->persona->id;
            $mov->idestado = 2;
            $mov->save();

            //APRUEBA EN LA TABLA
            $obj = SGCProceso_cero::withTrashed()->where("id",$request->id)->first();
            $obj->idestado = 2;
            $obj->idpersona_solicita = $mov->idpersona_solicita;
            $obj->idpersona_aprueba = auth()->user()->persona->id;
            $obj->idtipo_proceso    = $mov->idtipo_proceso;
            $obj->idtipo_accion = $mov->idtipo_accion;
            $obj->descripcion = $mov->descripcion;
            $obj->codigo = $mov->codigo;
            $obj->save();

            //ELIMINAR EN MOVIMIENTO
            if($mov->idtipo_accion == 3){
                $mov->delete();
            }
            //RESTAURAR EN MOVIMIENTO
            if($mov->idtipo_accion == 4){
                $mov->restore();
            }            
            //ELIMINAR EN LA TABLA
            if($obj->idtipo_accion == 3)
                $obj->delete();

            //RESTAURAR EN LA TABLA
            if($obj->idtipo_accion == 4)
                $obj->restore();
            return response()->json($obj);
        });
    }

    public function destroy(Request $request){

        $obj = SGCProceso_cero::withTrashed()->where("id",$request->id)->first();
        if($obj->procesos_uno->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel Cero ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }
        
        /**----------------------------SOLICITUD ELIMINAR---------- */
        if ($request->accion == "eliminar") {

            if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
                $data = array(
                    "type" => "error",
                    "text" => "No puedes eliminar un registro que está en estado Pendiente"
                );
                return response()->json($data);
            }

            $obj->idpersona_solicita = auth()->user()->persona->id;
            $obj->idtipo_accion = 3;
            $obj->idestado = 1;
            $obj->save();

            //MOVIMIENTO
            $mov = new MOVSGCMov_proceso_cero();
            $mov->idpersona_solicita = auth()->user()->persona->id;
            $mov->idtipo_proceso = $obj->idtipo_proceso;
            $mov->idtipo_accion = 3;
            $mov->idestado = 1;
            $mov->idsgc = $obj->id;
            $mov->codigo = $obj->codigo;
            $mov->descripcion = $obj->descripcion;
            $mov->save();

            return response()->json($obj);
        }

        /**----------------------SOLICITUD RESTAURAR---------------------- */
        if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
            $data = array(
                "type" => "error",
                "text" => "No puedes restaurar un registro que está en estado Pendiente"
            );
            return response()->json($data);
        }
        $obj->idpersona_solicita = auth()->user()->persona->id;
        $obj->idtipo_accion = 4;
        $obj->idestado = 1;
        $obj->save();
        
        //MOVIMIENTO
        $mov = new MOVSGCMov_proceso_cero();
        $mov->idpersona_solicita = auth()->user()->persona->id;
        $mov->idtipo_accion = 4;
        $mov->idestado = 1;
        $mov->idtipo_proceso = $obj->idtipo_proceso;
        $mov->idsgc = $obj->id;
        $mov->codigo = $obj->codigo;
        $mov->descripcion = $obj->descripcion;
        $mov->save();
        return response()->json($obj);   
    }
}
