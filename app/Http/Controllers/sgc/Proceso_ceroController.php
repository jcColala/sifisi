<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;

use App\Models\SGCProceso_cero;
use App\Models\MOVSGCMov_proceso_cero;
use App\Models\SGCEntidad;
use App\Models\SGCTipo_proceso;

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
        $this->model                = new SGCProceso_cero();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["tipo_proceso"]      = SGCTipo_proceso::get();
        $datos["responsable"]       = SGCEntidad::get();
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
        $objeto = SGCProceso_cero::
            join('sgc.estado', 'sgc.estado.id', '=', 'sgc.proceso_cero.idestado')
            ->select('sgc.proceso_cero.id as id', 'sgc.proceso_cero.descripcion as descripcion', 'sgc.proceso_cero.codigo as codigo', 'sgc.estado.descripcion as estado')
            ->orderBy('sgc.proceso_cero.idtipo_proceso', 'asc')
            ->withTrashed();
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
            'idtipo_proceso'=>'required',
            'codigo'=> 'required',
            'descripcion' => 'required',
            'idresponsable'=>'required',
            'objetivo'=>'required',
            'alcance'=>'required',
            ],[
            'idtipo_proceso.required' => 'Seleccione el tipo de proceso',
            'codigo.required'=> 'Escriba el código del proceso',
            'descripcion.required' => 'Escriba el Nombre del Proceso',
            'idresponsable.required' => 'Seleccione el responsable del proceso',
            'objetivo.required' => 'Escriba el objetivo del proceso',
            'alcance.required' => 'Escriba el alcance del proceso',
        ]);
        return DB::transaction(function() use ($request){
            $obj_mov = MOVSGCMov_proceso_cero::withTrashed()->find($request->id);

            if(is_null($obj_mov))
                $obj_mov = new MOVSGCMov_proceso_cero();
            $obj_mov->fill($request->all());
            $obj_mov->save();

            $obj = SGCProceso_cero::withTrashed()->find($request->id);

            if(is_null($obj))
                $obj = new SGCProceso_cero();
            $obj->fill($request->all());
            $obj->save();
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        $data  = SGCProceso_cero::withTrashed()->find($id);
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        /*$obj = SGCProceso_cero::withTrashed()->where("id",$request->id)->with("proceso_uno")->first();
        if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel Cero ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }*/
        if ($request->accion == "eliminar") {
            SGCProceso_cero::find($request->id)->delete();
            return response()->json();
        }
        SGCProceso_cero::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
