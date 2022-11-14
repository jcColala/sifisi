<?php

namespace App\Http\Controllers;

use App\Models\Funcion;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class FuncionController extends Controller
{
    public $modulo                  = "Funcion";
    public $path_controller         = "funcion";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public function __construct(){
        $this->model                = new Funcion();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "funcion";
        $datos["data"]              = [];
        if( $id != null )
            $datos["data"]          = Funcion::withTrashed()->find($id);

        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        $objeto = Funcion::withTrashed();
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
            'nombre'=>'required',
            'funcion'=>'required',
            'orden'=>'required'
            ]);

        return DB::transaction(function() use ($request){
            $obj        = Funcion::withTrashed()->find($request->id);

            if(is_null($obj))
                $obj    = new Funcion();
            $obj->fill($request->all());
            $obj->save();
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        $data  = Funcion::withTrashed()->find($id);
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        if ($request->accion == "eliminar") {
            Funcion::find($request->id)->delete();
            return response()->json();
        }
        Funcion::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
