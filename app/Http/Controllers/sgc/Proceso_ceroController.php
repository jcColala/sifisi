<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;
use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

/**-----------MODELS */
use App\Models\SGCProceso_cero;
use App\Models\MOVSGCMov_proceso_cero;
use App\Models\SGCTipo_proceso;

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
        $objeto = SGCProceso_cero::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->with('tipo_proceso')->orderBy('id', 'ASC')->withTrashed();

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
            $obj = SGCProceso_cero::withTrashed()->find($request->id);

            /**----------VALIDA SI ESTA VACIO PARA REGISTRAR */
            if(empty($obj)){
                $obj = new SGCProceso_cero();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->idtipo_proceso = $request->idtipo_proceso;
                $obj->codigo = $request->codigo_hidde;
                $obj->descripcion = $request->descripcion;
                $obj->save();

                return response()->json($obj);
            }

            /**----------VALIDA SI ESTA PENDIENTE */
            if($obj->idestado == 1){
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
            $obj->idtipo_proceso = $request->idtipo_proceso;
            $obj->codigo = $request->codigo_hidde;
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
            $obj = SGCProceso_cero::withTrashed()->find($request->id);

            /**-------VALIDA EL ESTADO PENDIENTE */
            if($obj->idestado == 1){
                $obj->idpersona_aprueba = auth()->user()->persona->id;
                $obj->idestado = 2;
                $obj->save();
    
                /**----------REGISTRA EL MOVIMIENTO */
                $mov = new MOVSGCMov_proceso_cero();
                $mov->idestado = $obj->idestado;
                $mov->idtipo_accion = $obj->idtipo_accion;
                $mov->idpersona_solicita = $obj->idpersona_solicita;
                $mov->idpersona_aprueba = $obj->idpersona_aprueba;
                $mov->idtipo_proceso    = $obj->idtipo_proceso;
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
        return DB::transaction(function () use($request){
            $obj = SGCProceso_cero::withTrashed()->find($request->id);

            /**-------VALIDA QUE EL ESTADO ESTE EN PENDIENTE */
            if($obj->idestado == 1){
                $data = array(
                    "type" => "error",
                    "text" => "No puedes ".$request->accion." un registro que está en estado Pendiente"
                );
                return response()->json($data);
            }
    
            /**-------VALIDA QUE NO TENGA DATOS RELACIONADO */
            if($obj->procesos_uno->isNotEmpty()){
                throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel Cero ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
            }

            /**-------------------SOLICITUD ELIMINAR----- */
            if ($request->accion == "eliminar") {
                $obj->idpersona_solicita = auth()->user()->persona->id;
                $obj->idtipo_accion = 3;
                $obj->idestado = 1;
                $obj->save();

                return response()->json($obj);
            }

            /**-----------------SOLICITUD RESTAURAR--- */
            $obj->idpersona_solicita = auth()->user()->persona->id;
            $obj->idtipo_accion = 4;
            $obj->idestado = 1;
            $obj->save();

            return response()->json($obj);  
        });
    }
}
