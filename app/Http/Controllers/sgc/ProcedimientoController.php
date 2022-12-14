<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;


use App\Models\comisiones\Comision;
use App\Models\SGCProcedimiento;
use App\Models\SGCIndicador_procedimiento;
use App\Models\SGCActividad_procedimiento;
use App\Models\MOVSGCMov_procedimiento;



use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;  
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class ProcedimientoController extends Controller
{
    public $modulo                  = "Procedimientos";
    public $path_controller         = "procedimiento";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new SGCProcedimiento();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["comisiones"]         = Comision::get();
        $datos["data"]              = [];
        $datos["indicadores"]       = [];
        $datos["actividades"]       = [];

        if( $id != null )
            $datos["data"]          = SGCProcedimiento::withTrashed()->find($id);   
        if($id != null)
            $datos["indicadores"]   = SGCIndicador_procedimiento::where('idprocedimiento', $id)->get();   
        if($id != null)
            $datos["actividades"]   = SGCActividad_procedimiento::where('idprocedimiento', $id)->get();  
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        //withTrashed
        $objeto = SGCProcedimiento::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->with('proceso_uno')->orderBy('id', 'ASC')->withTrashed()->get();

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
            ],[
            'version.required' => 'Escriba la versi??n del documento',
            'fecha_aprobado.required' => 'Seleccione la fecha en la que se aprob?? el documento',
        ]);

        return DB::transaction(function() use ($request){
            //LLENADO - EDICI??N EN LA TABLA MOVIMIENTOS
            /*$obj_mov        = MOVSGCMov_proceso_uno::withTrashed()->find($request->id);

            if(is_null($obj_mov))
                $obj_mov    = new MOVSGCMov_proceso_uno();
            $obj_mov->fill($request->all());
            $obj_mov->save();*/

            //LLENADO - EDICI??N EN LA TABLA SGC
            $obj        = SGCProcedimiento::withTrashed()->find($request->id);
            if(empty($obj))
            {
                /**REGISTRAR PROCESO DE NIVEL 2 */
                $obj    = new SGCProcedimiento();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->version = $request->version;
                $obj->fecha_aprobado = $request->fecha_aprobado;
                $obj->idproceso_uno = $request->idproceso_uno;
                $obj->idresponsable = $request->idresponsable;

                $mov    = new MOVSGCMov_procedimiento();
                $mov->idpersona_solicita = $request->idpersona_solicita;
                $mov->version = $request->version;
                $mov->fecha_aprobado = $request->fecha_aprobado;
                $mov->idproceso_uno = $request->idproceso_uno;
                $mov->idsgc = $obj->id;
                $mov->save();
            }else{
                if($obj->idestado == 1){//VALIDA SI EST?? PENDIENTE
                    $data = array(
                        "type" => "error",
                        "text" => "No puedes editar un registro que est?? en estado Pendiente"
                    );
                    return response()->json($data);
                }
                /**EDITAR PROCEDIMIENTO */
                $obj->idestado = 1;
                $obj->idtipo_accion = 2;
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->idpersona_aprueba = null;
                $obj->version = $request->version;
                $obj->fecha_aprobado = $request->fecha_aprobado;
                $obj->save();

                $mov    = new MOVSGCMov_procedimiento();
                $mov->idpersona_solicita = $request->idpersona_solicita;
                $mov->version_proceso_uno = $obj->version_proceso_uno;
                $mov->version = $request->version;
                $mov->codigo = $obj->codigo;
                $mov->descripcion = $obj->descripcion;
                $mov->fecha_aprobado = $request->fecha_aprobado;
                $mov->idproceso_uno = $obj->idproceso_uno;
                $mov->idsgc = $obj->id;
                $mov->save();

                //TABLA INDICADOR 
                for ($i = 0; $i < count($request->codigo_indicador); $i++) {
                    $indicador = new SGCIndicador_procedimiento();
                    $indicador->idestado = 2;
                    $indicador->idprocedimiento = $obj->id;
                    $indicador->idpersona_solicita = $request->idpersona_solicita;
                    $indicador->version_procedimiento = $request->version;
                    $indicador->codigo = $request->codigo_indicador[$i];
                    $indicador->descripcion = $request->descripcion_indicador[$i];
                    $indicador->save();
                }
                //ACTIVIDAD
                for ($i = 0; $i < count($request->descripcion_actividad); $i++) {
                    $actividad = new SGCActividad_procedimiento();
                    $actividad->idestado = 2;
                    $actividad->idprocedimiento = $obj->id;
                    $actividad->idpersona_solicita = $request->idpersona_solicita;
                    $actividad->version_procedimiento = $request->version; 
                    $actividad->descripcion = $request->descripcion_indicador[$i];
                    $actividad->idresponsable = $request->responsable_actividad[$i];
                    $actividad->correlativo = "1"; //ARREGLAR
                    $actividad->save();
                }
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
        $obj = SGCProcedimiento::withTrashed()->where("id",$request->id)->first();
        $obj->idpersona_aprueba = auth()->user()->persona->id;
        $obj->idestado = 2;
        $obj->save();

        /**-----ACTIVIDADES */
        $actividad = SGCActividad_procedimiento::where('idprocedimiento', $obj->id)->get();
        foreach($actividad as $acti){
            $acti->idestado = 2;
            $acti->idpersona_aprueba = $obj->idpersona_aprueba;
            $acti->save();
        }

        /**-----INDICADORES */
        $procedimiento = SGCIndicador_procedimiento::where('idprocedimiento', $obj->id)->get();
        foreach($procedimiento as $proc){
            $proc->idestado = 2;
            $proc->idpersona_aprueba = $obj->idpersona_aprueba;
            $proc->save();
        }
        return response()->json($obj);
    }

    public function destroy(Request $request){

        $obj = SGCProcedimiento::withTrashed()->where("id",$request->id)->first();
        /*if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel 1 ".$obj->descripcion." tiene informaci??n dentro de si por lo cual no se puede eliminar."]);
        }*/
        if ($request->accion == "eliminar") {
            SGCProcedimiento::find($request->id)->delete();
            return response()->json();
        }
        SGCProcedimiento::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
