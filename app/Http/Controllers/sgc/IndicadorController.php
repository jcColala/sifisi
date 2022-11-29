<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;

use App\Models\SGCProceso_cero;
use App\Models\MOVSGCMov_proceso_cero;
use App\Models\SGCIndicador;
use App\Models\MOVSGCMov_indicador;

use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class IndicadorController extends Controller
{
    public $modulo                  = "Indicadores";
    public $path_controller         = "indicador";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }
        $this->model                = new SGCIndicador();
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
            $datos["data"]          = SGCIndicador::withTrashed()->find($id);

        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){

        $objeto = SGCIndicador::
            join('sgc.estado', 'sgc.estado.id', '=', 'sgc.indicador.idestado')
            ->select('sgc.indicador.id as id', 'sgc.indicador.descripcion as descripcion', 'sgc.indicador.codigo as codigo', 'sgc.estado.descripcion as estado')
            ->orderBy('sgc.indicador.idproceso_uno', 'asc')
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
            $obj_mov = MOVSGCMov_indicador::withTrashed()->find($request->id);

            if(is_null($obj_mov))
                $obj_mov = new MOVSGCMov_indicador();
            $obj_mov->fill($request->all());
            $obj_mov->save();

            $obj = SGCIndicador::withTrashed()->find($request->id);

            if(is_null($obj))
                $obj = new SGCIndicador();
            $obj->fill($request->all());
            $obj->save();
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        $data  = SGCIndicador::withTrashed()->find($id);
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        /*$obj = SGCIndicador::withTrashed()->where("id",$request->id)->with("proceso_uno")->first();
        if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel Cero ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }*/
        if ($request->accion == "eliminar") {
            SGCIndicador::find($request->id)->delete();
            return response()->json();
        }
        SGCIndicador::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
