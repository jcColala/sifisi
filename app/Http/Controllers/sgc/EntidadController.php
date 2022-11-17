<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;
use App\Models\SGCEntidad;
use App\Models\MOVSGCMov_entidad;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class EntidadController extends Controller
{
    public $modulo                  = "Entidades";
    public $path_controller         = "entidad";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        $this->model                = new SGCEntidad();
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
            $datos["data"]          = SGCEntidad::withTrashed()->find($id);

        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){

        $objeto = SGCEntidad::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->withTrashed();
        
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
            'descripcion'=>'required',
            'cant_integrantes' => 'required',
            ],[
            'descripcion.required'=>'Ingresar el nombre del Tipo de Proceso',
            'cant_integrantes' => 'Ingresar la cantidad de integrantes de la entidad'

        ]);

        return DB::transaction(function() use ($request){
            /*$obj_mov = MOVSGCMov_entidad::withTrashed()->find($request->id);

            if(is_null($obj_mov)){
                $obj_mov = new MOVSGCMov_entidad();
                $obj_mov->idtipo_accion = 1;
                $obj_mov->descripcion = $request->descripcion;
                $obj_mov->cant_integrantes = $request->cant_integrantes;
                $obj_mov->save();
            }else{
                $obj_mov->idtipo_accion = 2;
                $obj_mov->descripcion = $request->descripcion;
                $obj_mov->cant_integrantes = $request->cant_integrantes;
                $obj_mov->save();
            }*/

            

            $obj = SGCEntidad::withTrashed()->find($request->id);

            if(is_null($obj)){
                $obj = new SGCEntidad();
                $obj->idtipo_accion = 1;
            }
                
            $obj->idtipo_accion = 2;
            $obj->descripcion = $request->descripcion;
            $obj->cant_integrantes = $request->cant_integrantes;
            $obj->save();
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        /*$obj = SGCEntidad::withTrashed()->where("id",$request->id)->with("proceso_uno")->first();
        if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel Cero ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }*/
        
        if ($request->accion == "eliminar") {
            $entidad = SGCEntidad::destroy($request->id);
            return response()->json($entidad);
        }
        /*SGCEntidad::withTrashed()->find($request->id)->restore();
        return response()->json();*/        
    }
}
