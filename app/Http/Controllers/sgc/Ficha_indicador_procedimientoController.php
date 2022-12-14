<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;



use App\Models\Funcion;
use App\Models\SGCDocumento;
use App\Models\SGCFicha_indicador_procedimiento;
use App\Models\SGCIndicador_uno;
use App\Models\SGCFicha_indicador_uno;
use App\Models\SGCIndicador_procedimiento;
use App\Models\SGCPeriodicidad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class Ficha_indicador_procedimientoController extends Controller
{
    public $modulo                  = "Ficha de Indicadores de Procedimientos";
    public $path_controller         = "ficha_indicador_procedimiento";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }
        $this->model                = new SGCFicha_indicador_procedimiento();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["data"]              = [];
        $datos["periodicidad"]      = SGCPeriodicidad::get();
        $datos["documentos"]        = SGCDocumento::get();
        $datos["indicadores"]       = SGCIndicador_procedimiento::get();
        if( $id != null )
            $datos["data"]          = SGCFicha_indicador_procedimiento::withTrashed()->find($id);
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        
        $objeto = SGCFicha_indicador_procedimiento::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->with('indicador_procedimiento')->withTrashed();
        return DataTables::of($objeto)
                ->addIndexColumn()
                ->addColumn("icono", function($objeto){
                    return "<i class='{$objeto->icono}'></i>";
                })
                ->addColumn("activo", function($row){
                    return (is_null($row->deleted_at))?'<span class="dot-label bg-success" data-toggle="tooltip" data-placement="top" title="Activo"></span>':'<span class="dot-label bg-danger" data-toggle="tooltip" data-placement="top" title="Inactivo"></span>';
                })->addColumn('estado', function($objeto){
                    return $objeto->tipo_accion->descripcion." ".$objeto->estado->descripcion;
                })
                ->rawColumns(
                    ['icono', "activo", "estado"]
                    )
                ->make(true);
    } 

    public function create(){

        return view("{$this->path_controller}.form",$this->form());
    }

    public function store(Request $request){
        $this->validate($request,[
            'version'     =>'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'fecha_aprobado'  =>'required',
            //'idresponsable'     =>'required',
            //'objetivo'          =>'required',
            //'variables'         =>'required',
            //'calculo'           =>'required',
            'idperiodicidad'   =>'required',
            //'porcentaje'        =>'required|integer',
            ],[
            'version.required'=>'Ingresar el version del documento',
            'fecha_aprobado.required'=>'Ingresar la fecha de aprobaci??n de la ficha del indicador',
            //'idresponsable.required'=>'Seleccionar el cargo responsable del indicador',
            //'objetivo.required' => 'Ingresar el objetivo del indicador',
            //'variables.required' => 'Ingresar las variables del indicador',
            //'calculo.required' => 'Ingresar calculo del indicador',
            'idperiodicidad.required' => 'Seleccionar la periodicidad de evaluaci??n',
            //'porcentaje.required' => 'Ingresar la cantidad de integrantes de la entidad',
        ]);

        return DB::transaction(function() use ($request){                                                                   
            $obj = SGCFicha_indicador_procedimiento::withTrashed()->find($request->id);

                if(empty($obj)){
                    $obj = new SGCFicha_indicador_procedimiento();
                    $obj->idpersona_solicita = $request->idpersona_solicita;
                    $obj->idtipo_accion = 1;
                    $obj->idindicador_procedimiento = $request->idindicador_procedimiento;
                    $obj->version  = $request->version;
                    $obj->fecha_aprobado = $request->fecha_aprobado;
                    $obj->idperiodicidad = $request->idperiodicidad;
                    
                    $obj->save();
                }
                else{
                    if($obj->idestado == 1){//VALIDA SI EST?? PENDIENTE
                        $data = array(
                            "type" => "error",
                            "text" => "No puedes editar un registro que est?? en estado Pendiente"
                        );
                        return response()->json($data);
                    }
                    $obj->idpersona_solicita = $request->idpersona_solicita;
                    $obj->idestado = 1;
                    $obj->idtipo_accion = 2;
                    $obj->idindicador_procedimiento = $request->idindicador_procedimiento;
                    $obj->version  = $request->version;
                    $obj->fecha_aprobado = $request->fecha_aprobado;
                    $obj->idperiodicidad = $request->idperiodicidad;
                    $obj->save();
                }
                

                //DOCUMENTOS
                /*for ($i=0; $i < count($request->iddocumento); $i++){ 
                    $inf = new SGCFicha_indicador_uno_informacion();
                    $inf->idpersona_solicita = $request->idpersona_solicita;
                    $inf->idindicador = $obj->id;
                    $inf->iddocumento = $request->iddocumento[$i];
                    $inf->save();
                }*/
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function ver($id){ 
        return view("{$this->path_controller}.form_disabled",$this->form($id));
    }

    public function aprobar(request $request){
        $obj = SGCFicha_indicador_procedimiento::withTrashed()->where("id",$request->id)->first();
        $obj->idpersona_aprueba = auth()->user()->persona->id;
            $obj->idestado = 2;
            $obj->save();
            return response()->json($obj);
    }

    public function destroy(Request $request){

        $obj = SGCFicha_indicador_procedimiento::withTrashed()->where("id",$request->id)->first();
        /*if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel Cero ".$obj->descripcion." tiene informaci??n dentro de si por lo cual no se puede eliminar."]);
        }*/
        
        if ($request->accion == "eliminar") {

            if($obj->idestado == 1){//VALIDA SI EST?? PENDIENTE
                $data = array(
                    "type" => "error",
                    "text" => "No puedes eliminar un registro que est?? en estado Pendiente"
                );
                return response()->json($data);
            }

            $obj->idpersona_solicita = auth()->user()->persona->dni;
            $obj->idtipo_accion = 3;
            $obj->idestado = 1;
            $obj->save();
            return response()->json($obj);
        }

        //RESTAURAR
        if($obj->idestado == 1){//VALIDA SI EST?? PENDIENTE
            $data = array(
                "type" => "error",
                "text" => "No puedes restaurar un registro que est?? en estado Pendiente"
            );
            return response()->json($data);
        }
        $obj->idpersona_solicita = auth()->user()->persona->dni;
        $obj->idtipo_accion = 4;
        $obj->idestado = 1;
        $obj->save();
        return response()->json($obj);
    }
}
