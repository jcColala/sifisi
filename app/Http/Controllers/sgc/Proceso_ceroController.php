<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;
use App\Models\Proceso_cero;

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
        $this->model                = new Proceso_cero();
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
            $datos["data"]          = Proceso_cero::withTrashed()->find($id);

        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        $objeto = Proceso_cero::withTrashed();
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
            ],[
            "descripcion.required"=>"Ingresar el nombre del Proceso de Nivel Cero",
        ]);

        return DB::transaction(function() use ($request){
            $obj        = Proceso_cero::withTrashed()->find($request->id);

            if(is_null($obj))
                $obj    = new Proceso_cero();
            $obj->fill($request->all());
            $obj->save();
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        $data  = Proceso_cero::withTrashed()->find($id);
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        $obj = Proceso_cero::withTrashed()->where("id",$request->id)->with("modulo")->first();
        if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El modulo padre ".$obj->descripcion." esta siendo utilizado por lo cual no se puede eliminar."]);
        }
        if ($request->accion == "eliminar") {
            Proceso_cero::find($request->id)->delete();
            return response()->json();
        }
        Proceso_cero::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
