<?php

namespace App\Http\Controllers\comisiones;
use App\Http\Controllers\Controller;
use App\Models\comisiones\Comision;
use App\Models\comisiones\Comision_responsable;
use App\Models\Funcion;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class ComisionController extends Controller
{
    public $modulo                  = "Comision";
    public $path_controller         = "comision";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new Comision();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $data_responsable           = "";
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["data"]              = [];
        if( $id != null ){
            $datos["data"]          = Comision::withTrashed()->find($id);
            $data_responsable       = Comision_responsable::with('persona')->where("idcomision",$id)->get();
        }
        $datos["data_responsable"]    = $data_responsable;
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }


    public function grilla(){

        $objeto = Comision::withTrashed();
        
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
        $now          = Carbon::now();
        $anio_actual  = $now->format('Y');
        $mes_actual   = $now->format('m');

        $this->validate($request,[
            'descripcion'=>'required|max:120',
            'abreviatura'=>'required|max:60',
            'resolucion'=>['required','max:60',Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "resolucion")
                    ->ignore($request->id, "id")],
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date|after_or_equal:fecha_inicio',
        ]);

        return DB::transaction(function() use ($request, $anio_actual, $mes_actual){
            $obj        = Comision::withTrashed()->find($request->id);

            if(is_null($obj)){
                $obj        = new Comision();
                $obj->anio  = $anio_actual;
                $obj->mes   = $mes_actual;
            }
            $obj->fill($request->all());

            if ($obj->save()) {
                if($request->filled("responsable")){
                    $cont_presidente = 0;
                    foreach($request->input("responsable") as $key => $value){
                        if($key == 0)
                            Comision_responsable::where("idcomision",$obj->id)->delete();
                        if ($value["presidente"] == "S")
                            $cont_presidente++;

                        $comision_responsable       = Comision_responsable::where("idcomision",$obj->id)->where('idresponsable',$value["id"])->withTrashed()->first();

                        if(is_null($comision_responsable))
                            $comision_responsable   = new Comision_responsable();
                        $comision_responsable->idcomision       = $obj->id;
                        $comision_responsable->idresponsable    = $value["id"];
                        $comision_responsable->presidente       = $value["presidente"];
                        $comision_responsable->deleted_at       = null;
                        $comision_responsable->save();
                    }

                    if ($cont_presidente != 1)
                        throw ValidationException::withMessages(["tab2" => "Es necesario selecionar el presidente de los responsable."]);

                }else{
                    throw ValidationException::withMessages(["tab2" => "Es necesario ingresar mínimo un responsable."]);
                }
            }
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){


    }
}
