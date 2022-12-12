<?php
namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Modulo_padre;
use App\Models\User;
use App\Models\Funcion;
use App\Models\Funcion_modulo;
use App\Models\Role_permisos;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ModuloController extends Controller
{
    public $modulo                  = "Modulo";
    public $path_controller         = "modulo";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    function __construct(){

        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new Modulo();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();
    }

    public function form($id = null){
        $funcion_modulo             = "";
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "modulo";
        $datos["modulo_padre"]      = Modulo_padre::get();
        $datos["funcion"]           = Funcion::where("mostrar","S")->get();
        $datos["data"]              = [];
        if( $id != null ){
            $datos["data"]     = Modulo::withTrashed()->find($id);
            $funcion_modulo    = Funcion_modulo::with('funcion')->where("idmodulo",$id)->get();
        }
        $datos["funcion_modulo"]    = $funcion_modulo;
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
                ->addColumn("estado", function($objeto){
                    return (is_null($objeto->deleted_at))?'<span class="dot-label bg-success" data-toggle="tooltip" data-placement="top" title="Activo"></span>':'<span class="dot-label bg-danger" data-toggle="tooltip" data-placement="top" title="Inactivo"></span>';
                })
                ->rawColumns(['icono', "estado"])
                ->make(true);
    }

    public function create(){
        return view("{$this->path_controller}.form",$this->form());
    }

    public function store(Request $request){
        $this->validate($request,[
            "idmodulo_padre"=>"required",
            "modulo"=>"required",
            "orden"=>"required|integer",
            "url"=>"required",
        ],[
            "idmodulo_padre.required"=>"El campo modulo padre es obligatorio.",
        ]);

        return DB::transaction(function() use ($request){
            $obj        = Modulo::withTrashed()->find($request->id);

            if(is_null($obj))
                $obj    = new Modulo();
            $obj->fill($request->all());

            if ($obj->save()) {
                if($request->filled("modulo_funcion")){
                    foreach($request->input("modulo_funcion") as $key => $value){
                        if($key == 0)
                            Funcion_modulo::where("idmodulo",$obj->id)->delete();

                        $funcion_modulo   = Funcion_modulo::where("idmodulo",$obj->id)->where('idfuncion',$value["id"])->withTrashed()->first();

                        if(is_null($funcion_modulo))
                            $funcion_modulo    = new Funcion_modulo();
                        $funcion_modulo->idmodulo       = $obj->id;
                        $funcion_modulo->idfuncion      = $value["id"];
                        $funcion_modulo->deleted_at     = null;
                        $funcion_modulo->save();
                    }

                }else{
                    Funcion_modulo::where("idmodulo",$obj->id)->delete();
                    //throw ValidationException::withMessages(['required_funcion' => $value["index"]]);
                }

                if ($request->id != null) {
                    $funcion_modulo = Funcion_modulo::with("funcion")->where("idmodulo",$obj->id)->whereNotNull("deleted_at")->withTrashed()->get();
                    foreach ($funcion_modulo as $key => $value) {
                        $name = $value["funcion"]["funcion"]."-".$obj->url;
                        $verificar = Permission::join('seguridad.role_permisos as r_p','seguridad.permisos.id','=','r_p.permission_id')->where("name",$name)->count();
                        if ($verificar >= 1)
                            throw ValidationException::withMessages(['required_accesos' => $value["id"]]);
                    }
                }

            }
            return response()->json($obj);
        });

    }

    public function edit($id){ 
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function update(Request $request){

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