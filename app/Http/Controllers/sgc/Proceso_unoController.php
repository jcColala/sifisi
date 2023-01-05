<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;

use App\Models\MOVSGCMov_proceso_uno;
use App\Models\COMCargo;
use App\Models\COMComisiones;
use App\Models\SGCProceso_cero;
use App\Models\SGCProceso_uno;
use App\Models\SGCTipo_proceso;
use App\Models\SGCIndicador_uno;
use App\Models\MOVSGCMov_indicador;

use App\Models\Funcion;
use App\Models\MOVSGCMov_responsables_proceso_uno;
use App\Models\SGCResponsables_proceso_uno;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;  
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class Proceso_unoController extends Controller
{
    public $modulo                  = "Procesos de Nivel 1";
    public $path_controller         = "proceso_uno";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new SGCProceso_uno();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["proceso_cero"]      = SGCProceso_cero::where('idestado', 2)->with('procesos_uno')->get();
        $datos["comisiones"]        = COMComisiones::get();
        $datos["tipo_proceso"]      = SGCTipo_proceso::get();
        $datos["data"]              = [];
        $datos["indicadores"]       = [];
        $datos["responsables"]      = [];

        if( $id != null )
            $datos["data"]          = SGCProceso_uno::withTrashed()->find($id);   
        if($id != null)
            $datos["indicadores"]   = SGCIndicador_uno::where('idproceso_uno', $id)->get();     
        if($id != null)
            $datos["responsables"]  = SGCResponsables_proceso_uno::where('idproceso_uno', $id)->with('responsable')->get();
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        //withTrashed
        $objeto = SGCProceso_uno::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->orderBy('id', 'ASC')->withTrashed();

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
            'version'=>'required',
            'fecha_aprobado'=>'required',
            'idproceso_cero'=>'required',
            'descripcion' => 'required',
            'idcomision_responsable' => 'required',
            'objetivo'=>'required',
            'alcance'=>'required',
            'codigo_indicador'=>'required',
            'descripcion_indicador'=>'required',

            ],[
            'version.required' => 'Escriba la versión del documento',
            'fecha_aprobado.required' => 'Seleccione la fecha en la que se aprobó el documento',
            'idproceso_cero.required' => 'Seleccione el Proceso Nivel Cero al que pertenece este Proceso Nivel 1',
            'descripcion.required' => 'Escriba el Nombre del Proceso',
            'idcomision_responsable' => 'Debes seleecionar el puesto que es responsable del proceso',
            'objetivo.required' => 'Escriba las salidas del Proceso',
            'alcance.required' => 'Escriba los clientes del Proceso',
            'codigo_indicador.required' => 'Escriba los clientes del Proceso',
            'descripcion_indicador.required' => 'Escriba los clientes del Proceso',
        ]);

        return DB::transaction(function() use ($request){
            //LLENADO - EDICIÓN EN LA TABLA MOVIMIENTOS
            /*$obj_mov        = MOVSGCMov_proceso_uno::withTrashed()->find($request->id);

            if(is_null($obj_mov))
                $obj_mov    = new MOVSGCMov_proceso_uno();
            $obj_mov->fill($request->all());
            $obj_mov->save();*/

            $obj        = SGCProceso_uno::withTrashed()->find($request->id);
            if(empty($obj))
            {
                $obj = new SGCProceso_uno();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->version = $request->version;
                $obj->fecha_aprobado = $request->fecha_aprobado;
                $obj->idproceso_cero = $request->idproceso_cero;
                $obj->codigo = $request->codigo_hidde;
                $obj->descripcion = $request->descripcion;
                $obj->objetivo  = $request->objetivo;
                $obj->alcance = $request->alcance;
                $obj->save();

                $mov = new MOVSGCMov_proceso_uno();
                $mov->idpersona_solicita = $request->idpersona_solicita;
                $mov->version = $request->version;
                $mov->fecha_aprobado = $request->fecha_aprobado;
                $mov->idproceso_cero = $request->idproceso_cero;
                $mov->idsgc = $obj->id;
                $mov->codigo = $request->codigo_hidde;
                $mov->descripcion = $request->descripcion;
                $mov->objetivo  = $request->objetivo;
                $mov->alcance = $request->alcance;
                $mov->save();
            }else{
                $obj->idestado = 1;
                $obj->idtipo_accion = 2;
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->version = $request->version;
                $obj->fecha_aprobado = $request->fecha_aprobado;
                $obj->idproceso_cero = $request->idproceso_cero;
                $obj->codigo = $request->codigo_hidde;
                $obj->descripcion = $request->descripcion;
                $obj->objetivo  = $request->objetivo;
                $obj->alcance = $request->alcance;
                $obj->save();

                $mov = new MOVSGCMov_proceso_uno();
                $mov->idpersona_solicita = $request->idpersona_solicita;
                $mov->idestado = 1;
                $mov->idtipo_accion = 2;
                $mov->version = $request->version;
                $mov->fecha_aprobado = $request->fecha_aprobado;
                $mov->idproceso_cero = $request->idproceso_cero;
                $mov->idsgc = $obj->id;
                $mov->codigo = $request->codigo_hidde;
                $mov->descripcion = $request->descripcion;
                $mov->objetivo  = $request->objetivo;
                $mov->alcance = $request->alcance;
            }
                
            //!INDICADORES
            //movimiento
            /*for ($i=0; $i < count($request->codigo_indicador); $i++) { 
                $indicador_mov  = MOVSGCMov_indicador::where('codigo',$request->codigo_indicador[$i])->first();
                
                if(is_null($indicador_mov))
                    $indicador_mov = new MOVSGCMov_indicador();
                $indicador_mov->idproceso_uno = $obj->id;
                $indicador_mov->idpersona_solicita = $request->idpersona_solicita;
                $indicador_mov->codigo = $request->codigo_indicador[$i];
                $indicador_mov->descripcion = $request->descripcion_indicador[$i];
                $indicador_mov->version = $request->version;
                $indicador_mov->save();
            }*/

            //TABLA INDICADOR 
            for ($i=0; $i < count($request->codigo_indicador); $i++){ 
                $indicador  = SGCIndicador_uno::where('codigo',$request->codigo_indicador[$i])->first();
                
                if(is_null($indicador))
                    $indicador = new SGCIndicador_uno();
                $indicador->idproceso_uno = $obj->id;
                $indicador->idpersona_solicita = $request->idpersona_solicita;
                $indicador->version_proceso_uno = $request->version;
                $indicador->codigo = $request->codigo_indicador[$i];
                $indicador->descripcion = $request->descripcion_indicador[$i];
                $indicador->save();
            }

            //TABLA RESPONSABLES
            for ($i=0; $i < count($request->idcomision_responsable); $i++){ 
                $responsable  = SGCResponsables_proceso_uno::where('idcomision_responsable',$request->idcomision_responsable[$i])->where('idproceso_uno', $obj->id)->first();
                
                if(is_null($responsable))
                    $responsable = new SGCResponsables_proceso_uno();
                $responsable->idpersona_solicita = $request->idpersona_solicita;
                $responsable->idproceso_uno = $obj->id;
                $responsable->idcomision_responsable = $request->idcomision_responsable[$i];
                $responsable->version_proceso_uno = $request->version;
                $responsable->save();
            }
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
        $obj = SGCProceso_uno::withTrashed()->where("id",$request->id)->first();
        $obj->idpersona_aprueba = auth()->user()->persona->id;
            $obj->idestado = 2;
            $obj->save();
            return response()->json($obj);
    }

    public function destroy(Request $request){

        $obj = SGCProceso_uno::withTrashed()->where("id",$request->id)->first();
        if($obj->procesos_dos->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel 1 ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }
        if ($request->accion == "eliminar") {
            SGCProceso_uno::find($request->id)->delete();
            return response()->json();
        }
        SGCProceso_uno::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
