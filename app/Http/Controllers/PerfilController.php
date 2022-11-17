<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Funcion;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PerfilController extends Controller
{
    public $modulo                  = "Perfil";
    public $path_controller         = "perfil";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public function __construct(){

        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }
        
        $this->model                = new Perfil();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "perfil";
        $datos["data"]              = [];
        if( $id != null )
            $datos["data"]          = Perfil::withTrashed()->find($id);

        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        $objeto = Perfil::withTrashed();
        return DataTables::of($objeto)
                ->addIndexColumn()
                ->addColumn("estado", function($row){
                    return (is_null($row->deleted_at))?'<span class="dot-label bg-success" data-toggle="tooltip" data-placement="top" title="Activo"></span>':'<span class="dot-label bg-danger" data-toggle="tooltip" data-placement="top" title="Inactivo"></span>';
                })
                ->rawColumns(["estado"])
                ->make(true);
    }

    public function create(){
        return view("{$this->path_controller}.form",$this->form());
    }

    public function store(Request $request){
        $this->validate($request,[
            'perfil'=>'required'
            ]);

        return DB::transaction(function() use ($request){
            $obj        = Perfil::withTrashed()->find($request->id);

            if(is_null($obj))
                $obj    = new Perfil();
            $obj->fill($request->all());
            $obj->save();
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        if ($request->accion == "eliminar") {
            Perfil::find($request->id)->delete();
            return response()->json();
        }
        Perfil::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
