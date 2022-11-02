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
        $datos["modulo_padre"]      = Modulo_padre::withTrashed()->get();
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
                    return (is_null($row->deleted_at))?"<span class='dot-label bg-success'></span>":"<span class='dot-label bg-danger'></span>";
                })
                ->rawColumns(['icono', "activo"])
                ->make(true);
    }

    public function create(){
        return view("{$this->path_controller}.form",$this->form());
    }

    public function store(Request $request){

        dd($request);
        
        $this->validate($request,[
            "codsistema"=>"required",
            "modulos"=>"required",
            "abreviatura"=>"required",
            "orden"=>"required|integer",
            "icono"=>"required",
        ],[
            "codsistema.required"=>"El campo Sistema es obligatorio",
            "orden.required"=>"Ingrese el orden"
        ]);

    }

    public function edit($id){ 
        $data  = Modulo::withTrashed()->find($id);
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
}