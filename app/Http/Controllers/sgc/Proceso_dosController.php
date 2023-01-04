<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;


use App\Models\COMComisiones;
use App\Models\SGCProceso_uno;
use App\Models\SGCProceso_dos;
use App\Models\SGCIndicador_dos;
use App\Models\SGCActividades_proceso_dos;
use App\Models\MOVSGCMov_proceso_dos;



use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;  
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class Proceso_dosController extends Controller
{
    public $modulo                  = "Procesos de Nivel 2";
    public $path_controller         = "proceso_dos";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new SGCProceso_dos();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["proceso_uno"]      = SGCProceso_uno::where('idestado', 2)->with('procesos_dos')->get();
        $datos["entidades"]         = COMComisiones::get();
        $datos["data"]              = [];
        $datos["indicadores"]       = [];
        $datos["actividades"]       = [];

        if( $id != null )
            $datos["data"]          = SGCProceso_dos::withTrashed()->find($id);   
        if($id != null)
            $datos["indicadores"]   = SGCIndicador_dos::where('idproceso_dos', $id)->get();   
        if($id != null)
            $datos["actividades"]   = SGCActividades_proceso_dos::where('idproceso_dos', $id)->get();  
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        //withTrashed
        $objeto = SGCProceso_dos::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->orderBy('id', 'ASC')->get();

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
            'version'=>'required',
            'fecha_aprobado'=>'required',
            'idproceso_uno'=>'required',
            'descripcion' => 'required',
            'idresponsable' => 'required',
            'objetivo'=>'required',
            'alcance'=>'required',
            'proveedores'=>'required',
            'entradas'=>'required',
            'salidas'=>'required',
            'clientes'=>'required',
            ],[
            'version.required' => 'Escriba la versión del documento',
            'fecha_aprobado.required' => 'Seleccione la fecha en la que se aprobó el documento',
            'idproceso_uno.required' => 'Seleccione el Proceso Nivel Cero al que pertenece este Proceso Nivel 1',
            'descripcion.required' => 'Escriba el Nombre del Proceso',
            'idresponsable' => 'Debes seleecionar el puesto que es responsable del proceso',
            'objetivo.required' => 'Escriba los objetivos del Proceso',
            'alcance.required' => 'Escriba el alcance del Proceso',
            'proveedores.required' => 'Escriba los proveedores del Proceso',
            'entradas.required' => 'Escriba las entradas del Proceso',
            'salidas.required' => 'Escriba las salidas del Proceso',
            'clientes.required' => 'Escriba los clientes del Proceso',
        ]);

        return DB::transaction(function() use ($request){
            //LLENADO - EDICIÓN EN LA TABLA MOVIMIENTOS
            /*$obj_mov        = MOVSGCMov_proceso_uno::withTrashed()->find($request->id);

            if(is_null($obj_mov))
                $obj_mov    = new MOVSGCMov_proceso_uno();
            $obj_mov->fill($request->all());
            $obj_mov->save();*/

            //LLENADO - EDICIÓN EN LA TABLA SGC
            $obj        = SGCProceso_dos::withTrashed()->find($request->id);
            if(empty($obj))
            {
                /**REGISTRAR PROCESO DE NIVEL 2 */
                $obj    = new SGCProceso_dos();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->version = $request->version;
                $obj->fecha_aprobado = $request->fecha_aprobado;
                $obj->idproceso_uno = $request->idproceso_uno;
                $obj->codigo = $request->codigo_hidde;
                $obj->descripcion = $request->descripcion;
                $obj->idresponsable = $request->idresponsable;
                $obj->objetivo  = $request->objetivo;
                $obj->alcance = $request->alcance;
                $obj->proveedores = $request->proveedores;
                $obj->entradas = $request->entradas;
                $obj->salidas = $request->salidas;
                $obj->clientes = $request->clientes;
                $obj->save();

                $mov    = new MOVSGCMov_proceso_dos();
                $mov->idpersona_solicita = $request->idpersona_solicita;
                $mov->version = $request->version;
                $mov->fecha_aprobado = $request->fecha_aprobado;
                $mov->idproceso_uno = $request->idproceso_uno;
                $mov->idsgc = $obj->id;
                $mov->codigo = $request->codigo_hidde;
                $mov->descripcion = $request->descripcion;
                $mov->idresponsable = $request->idresponsable;
                $mov->objetivo  = $request->objetivo;
                $mov->alcance = $request->alcance;
                $mov->proveedores = $request->proveedores;
                $mov->entradas = $request->entradas;
                $mov->salidas = $request->salidas;
                $mov->clientes = $request->clientes;
                $mov->save();
            }else{
                /**EDITAR PROCESO DE NIVEL 2 */
                $obj->idestado = 1;
                $obj->idtipo_accion = 2;
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->idpersona_aprueba = null;
                $obj->save();

                $mov    = new MOVSGCMov_proceso_dos();
                $mov->idpersona_solicita = $request->idpersona_solicita;
                $mov->version = $request->version;
                $mov->fecha_aprobado = $request->fecha_aprobado;
                $mov->idproceso_uno = $request->idproceso_uno;
                $mov->idsgc = $obj->id;
                $mov->codigo = $request->codigo_hidde;
                $mov->descripcion = $request->descripcion;
                $mov->idresponsable = $request->idresponsable;
                $mov->objetivo  = $request->objetivo;
                $mov->alcance = $request->alcance;
                $mov->proveedores = $request->proveedores;
                $mov->entradas = $request->entradas;
                $mov->salidas = $request->salidas;
                $mov->clientes = $request->clientes;
                $mov->save();
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

            //REGISTRAR INDICADORES NIVEL 2
            for ($i=0; $i < count($request->descripcion_actividad); $i++){ 
                $actividad  = SGCActividades_proceso_dos::where('id',$request->id_actividad[$i])->first();
                
                if(is_null($actividad))
                    $actividad = new SGCActividades_proceso_dos();
                $actividad->idproceso_dos = $obj->id;
                $actividad->idpersona_solicita = $request->idpersona_solicita;
                $actividad->descripcion = $request->descripcion_actividad[$i];
                $actividad->idresponsable = $request->idresponsable_actividad[$i];
                $actividad->registro = $request->registro[$i];
                $actividad->correlativo = 1;
                $actividad->save();
            }

            //REGISTRAR INDICADORES NIVEL 2
            for ($i=0; $i < count($request->codigo_indicador); $i++){ 
                $indicador  = SGCIndicador_dos::where('codigo',$request->codigo_indicador[$i])->first();
                
                if(is_null($indicador))
                    $indicador = new SGCIndicador_dos();
                $indicador->idproceso_dos = $obj->id;
                $indicador->idpersona_solicita = $request->idpersona_solicita;
                $indicador->codigo = $request->codigo_indicador[$i];
                $indicador->descripcion = $request->descripcion_indicador[$i];
                $indicador->save();
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
        $obj = SGCProceso_dos::withTrashed()->where("id",$request->id)->first();
        $obj->idpersona_aprueba = auth()->user()->persona->id;
            $obj->idestado = 2;
            $obj->save();
            return response()->json($obj);
    }

    public function destroy(Request $request){

        $obj = SGCProceso_dos::withTrashed()->where("id",$request->id)->first();
        /*if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel 1 ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }*/
        if ($request->accion == "eliminar") {
            SGCProceso_dos::find($request->id)->delete();
            return response()->json();
        }
        SGCProceso_dos::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
