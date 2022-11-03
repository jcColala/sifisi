<?php
namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Modulo_padre;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;

class ModuloController extends Controller
{
    public $modulo                  = "Modulo";
    public $path_controller         = "modulo";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public function __construct(){
        $this->model                = new Modulo();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "modulo";
        $datos["modulo_padre"]      = Modulo_padre::get();
        $datos["data"]              = [];
        if( $id != null )
            $datos["data"]          = Modulo::withTrashed()->find($id);
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        $objeto = Modulo::with('padre')->with('modulopadre')->withTrashed();
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
            "idmodulo_padre"=>"required",
            "modulo"=>"required",
            "abreviatura"=>"required",
            "orden"=>"required|integer",
            "url"=>"required",
        ],[
            "idmodulo_padre.required"=>"Ingrese el Módulo padre.",
            "orden.required"=>"Ingrese el orden.",
            "orden.integer"=>"El orden debe tener un valor numerico entero."
        ]);

        return DB::transaction(function() use ($request){
            $obj        = Modulo::withTrashed()->find($request->id);

            if(is_null($obj))
                $obj    = new Modulo();
            $obj->fill($request->all());
            $obj->save();
            return response()->json($obj);
        });

    }

    public function edit($id){ 
        $data   = Modulo::withTrashed()->find($id);
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        if ($request->accion == "eliminar") {
            Modulo::find($request->id)->delete();
            return response()->json();
        }
        Modulo::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }

    public function get_modulos(Request $request){
        $obj  = Modulo::where("idmodulo_padre", $request->idmodulo_padre)->get();
        if( $request->id != null)
            $obj = Modulo::where("idmodulo_padre", $request->idmodulo_padre)->where("id", "!=", $request->id)->get();        
        return response()->json($obj);
    }
}