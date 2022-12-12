<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;

use App\Models\SGCIndicador;


use App\Models\Funcion;
use App\Models\SGCDocumento;
use App\Models\SGCEntidad;
use App\Models\SGCIndicador_informacion;
use App\Models\SGCPeriodicidad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class IndicadorController extends Controller
{
    public $modulo                  = "Indicadores";
    public $path_controller         = "indicador";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }
        $this->model                = new SGCIndicador();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["data"]              = [];
        $datos["entidades"]         = SGCEntidad::get();
        $datos["periodicidad"]      = SGCPeriodicidad::get();
        $datos["documentos"]        = SGCDocumento::get();
        $datos["informacion"]       = [];
        if( $id != null )
            $datos["data"]          = SGCIndicador::withTrashed()->find($id);

        if( $id != null)
            $datos["informacion"]   = SGCIndicador_informacion::where("idindicador", $id)->get();
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){

        $objeto = SGCIndicador::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->with('proceso_uno')->withTrashed();
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
            'version_ficha'     =>'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'fecha_aprobacion'  =>'required',
            'idresponsable'     =>'required',
            'objetivo'          =>'required',
            'variables'         =>'required',
            'calculo'           =>'required',
            'fecha_aprobacion'  =>'required',
            'idperiodicidad'   =>'required',
            'porcentaje'        =>'required|integer',
            'idelaborado'       =>'required',
            'idrevisado'        =>'required',
            'idaprobado'        =>'required'
            ],[
            'version_ficha.required'=>'Ingresar el version del documento',
            'fecha_aprobacion.required'=>'Ingresar la fecha de aprobación de la ficha del indicador',
            'idresponsable.required'=>'Seleccionar el cargo responsable del indicador',
            'objetivo.required' => 'Ingresar el objetivo del indicador',
            'variables.required' => 'Ingresar las variables del indicador',
            'calculo.required' => 'Ingresar calculo del indicador',
            'fecha_aprobacion.required' => 'Seleccionar la fecha de aprobación',
            'idperiodicidad.required' => 'Seleccionar la periodicidad de evaluación',
            'porcentaje.required' => 'Ingresar la cantidad de integrantes de la entidad',
            'porcentaje.integer' => 'La cantidad de integrantes debe ser un número entero',
            'idelaborado.required' => 'Seleccionar quién elaboró el documento',
            'idrevisado.required' => 'Seleccionar quién revisó el documento',
            'idaprobado.required' => 'Seleccionar quién aprobó el documento',
        ]);

        return DB::transaction(function() use ($request){            
            $obj = SGCIndicador::withTrashed()->find($request->id);
                /*if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
                    $data = array(
                        "type" => "error",
                        "text" => "No puedes editar un registro que está en estado Pendiente"
                    );
                    return response()->json($data);
                }*/
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->idtipo_accion = 1;
                $obj->version_ficha  = $request->version_ficha;
                $obj->fecha_aprobacion = $request->fecha_aprobacion;
                $obj->idresponsable        = $request->idresponsable;
                $obj->objetivo = $request->objetivo;
                $obj->variables = $request->variables;
                $obj->calculo = $request->calculo;
                $obj->idperiodicidad = $request->idperiodicidad;
                $obj->porcentaje       = $request->porcentaje;
                $obj->idelaborado        = $request->idelaborado;
                $obj->idrevisado        = $request->idrevisado;
                $obj->idaprobado        = $request->idaprobado;
                $obj->save();

                for ($i=0; $i < count($request->iddocumento); $i++){ 
                    $inf = new SGCIndicador_informacion();
                    $inf->idpersona_solicita = $request->idpersona_solicita;
                    $inf->idindicador = $obj->id;
                    $inf->iddocumento = $request->iddocumento[$i];
                    $inf->save();
                }
            return response()->json($obj);
        });
        
    }

    public function edit($id){ 
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function destroy(Request $request){

        $obj = SGCIndicador::withTrashed()->where("id",$request->id)->first();
        /*if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel Cero ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }*/
        if($request->accion = "aprobar"){
            $obj->idpersona_aprueba = auth()->user()->persona->id;
            $obj->idestado = 2;
            $obj->save();

            return response()->json($obj);

        }
        
        if ($request->accion == "eliminar") {

            if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
                $data = array(
                    "type" => "error",
                    "text" => "No puedes eliminar un registro que está en estado Pendiente"
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
        if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
            $data = array(
                "type" => "error",
                "text" => "No puedes restaurar un registro que está en estado Pendiente"
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
