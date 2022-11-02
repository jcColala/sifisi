<?php

namespace App\Http\Controllers;

use App\Models\Modulo_padre;
use App\Models\Modulo;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class Modulo_padreController extends Controller
{
    public $modulo                  = "Modulo Padre";
    public $path_controller         = "modulo_padre";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        $this->model                = new Modulo_padre();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "modulo_padre";
        $datos["data"]              = [];
        if( $id != null )
            $datos["data"]          = Modulo_padre::withTrashed()->find($id);

        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        $objeto = Modulo_padre::withTrashed();
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
            'abreviatura'=>'required',
            'icono'=>'required',
            'orden'=>'required|integer'
            ],[
            "descripcion.required"=>"Ingresar el nombre del modulo padre",
            "abreviatura.required"=>"Ingresar la abreviatura del sistema",
            "icono.required"=>"Ingresar el icono del sistema",
            "orden.required"=>"Ingresar el orden",
            "orden.integer"=>"El orden debe tener un valor numerico entero"
        ]);

        return DB::transaction(function() use ($request){
            $obj        = Modulo_padre::withTrashed()->find($request->id);

            if(is_null($obj))
                $obj    = new Modulo_padre();
            $obj->fill($request->all());
            $obj->save();
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        $data  = Modulo_padre::withTrashed()->find($id);
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        $obj = Modulo_padre::withTrashed()->where("id",$request->id)->with("modulo")->first();
        if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El modulo padre ".$obj->descripcion." esta siendo utilizado por lo cual no se puede eliminar."]);
        }
        if ($request->accion == "eliminar") {
            Modulo_padre::find($request->id)->delete();
            return response()->json();
        }
        Modulo_padre::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
