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

    public $dataTableServer         = null;

    public function __construct(){
        $this->model                = new Modulo();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function index(){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos['sistema']           = Modulo_padre::get();

        return view("{$this->path_controller}.index", $datos);
    }

    public function grilla(){
        $objeto = Modulo::with('padre')->with('modulopadre')->withTrashed();
        return DataTables::of($objeto)
                ->addIndexColumn()
                ->addColumn("icon", function($objeto){
                    return "<i class='fa fa-1x {$objeto->icono}'></i>";
                })
                ->addColumn("activo", function($row){
                    return (is_null($row->deleted_at))?"<span class='dot-label bg-success'></span>":"<span class='dot-label bg-danger'></span>";
                })
                ->rawColumns(['icon', "activo"])
                ->make(true);
    }

    public function edit($id){
        $obj    =   Modulo::withBotones()->withTrashed()->find($id);
        return response()->json($obj);
    }

    public function store(Request $request){
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

        if($request->filled("url")){
            $this->validate($request, [
                'url'=>[
                    "required"
                    , Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "url")
                            ->ignore($request->input("cod{$this->name_table}"), "cod{$this->name_table}")
                ],
            ]);
        }

        return DB::transaction(function() use ($request){
            $obj                = Modulo::withTrashed()->find($request->input("cod{$this->name_table}"));

            if(is_null($obj))
                $obj            = new Modulo();

            $obj->deleted_at    = ($request->input("activo")=="S")?null:date("Y-m-d H:i:s");
            $obj->fill($request->all());

            if($obj->save()){
                $botones_activos = [];
                if ($request->has('botones_modulo')){
                    foreach($request->input('botones_modulo') as $key=>$value){
                        if(!empty($value['coddetalle_boton']))
                            $detalle                = DetalleBoton::find($value['coddetalle_boton']);
                        else{
                            $detalle                = DetalleBoton::where("codboton", $value['codboton'])
                                ->where("codmodulos", $obj->codmodulos)
                                ->withTrashed()
                                ->first();

                            if(!is_null($detalle))
                                $detalle->deleted_at        = null;
                            else
                                $detalle                = new DetalleBoton();
                        }

                        $detalle->codboton          = $value['codboton'];
                        $detalle->codmodulos        = $obj->codmodulos;
                        $detalle->orden             = ($key+1);
                        $detalle->save();

                        $botones_activos[] = $detalle->codboton;
                    }
                }
                DetalleBoton::where("codmodulos", $obj->codmodulos)->whereNotIn("codboton", $botones_activos)->delete();
            }
            return response()->json($obj);
        });
    }

    public function destroy($id){
        $obj    =   Modulo::findOrFail($id);
        $obj->delete();
        return response()->json();
    }
}