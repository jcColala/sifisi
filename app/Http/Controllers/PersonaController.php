<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Funcion;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PersonaController extends Controller
{
    public $modulo                  = "Persona";
    public $path_controller         = "persona";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public function __construct(){

        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }
        
        $this->model                = new Persona();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "persona";
        $datos["data"]              = [];
        if( $id != null )
            $datos["data"]          = Persona::withTrashed()->find($id);

        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        $objeto = Persona::withTrashed();
        return DataTables::of($objeto)
                ->addIndexColumn()
                ->addColumn("estado", function($objeto){
                    return (is_null($objeto->deleted_at))?'<span class="dot-label bg-success" data-toggle="tooltip" data-placement="top" title="Activo"></span>':'<span class="dot-label bg-danger" data-toggle="tooltip" data-placement="top" title="Inactivo"></span>';
                })
                ->rawColumns(["estado"])
                ->make(true);
    }

    public function create(){
        return view("{$this->path_controller}.form",$this->form());
    }

    public function store(Request $request){
        
    }

    public function edit($id){ 
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function buscar($search, Request $request){
        //$search    = Str::upper($search);
        $consulta = Persona::where('numero_documento_identidad','LIKE','%'.$search.'%')
                           ->orWhere('nombres','LIKE','%'.$search.'%')
                           ->orWhere('apellido_paterno','LIKE','%'.$search.'%')
                           ->orWhere('apellido_materno','LIKE','%'.$search.'%')
                           ->take(10)->get();

        $array = [];
        foreach ($consulta as $key) {
            $array = [
                      'label'           =>$key->id." - ".$key->nombres." ".$key->apellido_paterno." ".$key->apellido_materno,
                      'id'              =>$key->id,
                      'nombres'         =>$key->nombres." ".$key->apellido_paterno." ".$key->apellido_materno,
                      'dni_ruc'         =>$key->id
                    ];
            $datos["search"] = [$array];

        }


      return $datos;
    }
    public function destroy(Request $request){

        if ($request->accion == "eliminar") {
            Persona::find($request->id)->delete();
            return response()->json();
        }
        Persona::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
