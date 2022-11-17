<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;
use App\Models\SGCTipo_proceso;
use App\Models\MOVSGCMov_tipo_proceso;
use App\Models\SGCTipo_accion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class Tipo_procesoController extends Controller
{
    public $modulo                  = "Tipos de Procesos";
    public $path_controller         = "tipo_proceso";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
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
                })
                ->rawColumns(['icono', "activo"])
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
            'codigo'=> 'Escriba el código del tipo de proceso',
            'descripcion' => 'Escriba el Nombre del Tipo de Proceso',
        ]);

        return DB::transaction(function() use ($request){
            $obj        = SGCTipo_proceso::withTrashed()->find($request->id);

            if(is_null($obj))
                $obj    = new SGCTipo_proceso();
            $obj->fill($request->all());
            $obj->save();
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        $data  = SGCTipo_proceso::withTrashed()->find($id);
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        /*$obj = SGCProceso_uno::withTrashed()->where("id",$request->id)->with("proceso_uno")->first();
        if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel Cero ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }*/
        if ($request->accion == "eliminar") {
            SGCTipo_proceso::find($request->id)->delete();
            return response()->json();
        }
        SGCTipo_proceso::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
