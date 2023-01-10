<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;
use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

/**---------MODELS */
use App\Models\SGCProceso_cero;
use App\Models\SGCProceso_uno;
use App\Models\MOVSGCMov_proceso_uno;
use App\Models\SGCIndicador_uno;
use App\Models\MOVSGCMov_indicador_uno;
use App\Models\SGCProcedimiento;
use App\Models\MOVSGCMov_procedimiento;

class Proceso_unoController extends Controller
{
    public $modulo                  = "Procesos de Nivel 1";
    public $path_controller         = "proceso_uno";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct()
    {
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new SGCProceso_uno();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();
    }

    public function form($id = null)
    {
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["proceso_cero"]      = SGCProceso_cero::where('idestado', 2)->with('procesos_uno')->get();
        $datos["data"]              = [];
        $datos["indicadores"]       = [];
        $datos["procedimientos"]    = [];

        if ($id != null)
            $datos["data"]          = SGCProceso_uno::withTrashed()->find($id);
        if ($id != null)
            $datos["indicadores"]   = SGCIndicador_uno::where('idproceso_uno', $id)->where('version_proceso_uno', $datos["data"]->version)->orderBy('id')->get();
        if ($id != null)
            $datos["procedimientos"] = SGCProcedimiento::where('idproceso_uno', $id)->where('version_proceso_uno', $datos["data"]->version)->orderBy('id')->get();
        return $datos;
    }

    public function index()
    {
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla()
    {
        $objeto = SGCProceso_uno::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->orderBy('id', 'ASC')->withTrashed();

        return DataTables::of($objeto)
            ->addIndexColumn()
            ->addColumn("icono", function ($objeto) {
                return "<i class='{$objeto->icono}'></i>";
            })
            ->addColumn("activo", function ($row) {
                return (is_null($row->deleted_at)) ? '<span class="dot-label bg-success" data-toggle="tooltip" data-placement="top" title="Activo"></span>' : '<span class="dot-label bg-danger" data-toggle="tooltip" data-placement="top" title="Inactivo"></span>';
            })->addColumn('estado', function ($objeto) {
                return $objeto->tipo_accion->descripcion . " " . $objeto->estado->descripcion;
            })
            ->rawColumns(
                ['icono', "activo", "estado"]
            )
            ->make(true);
    }

    public function create()
    {
        return view("{$this->path_controller}.form", $this->form());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'idproceso_cero' => 'required',
            'descripcion' => 'required',
            'version' => 'required',
            'fecha_aprobado' => 'required',
            //'diagrama' => 'required',
            //'documento' => 'required',
            'codigo_indicador.*' => 'required',
            'descripcion_indicador.*' => 'required',
            'codigo_procedimiento.*' => 'required',
            'descripcion_procedimiento.*' => 'required',

        ], [
            'version.required' => 'Escriba la versión del documento',
            'fecha_aprobado.required' => 'Seleccione la fecha en la que se aprobó el documento',
            'idproceso_cero.required' => 'Seleccione el Proceso Nivel Cero al que pertenece este Proceso Nivel 1',
            'descripcion.required' => 'Escriba el Nombre del Proceso',
            'diagrama.required' => 'Debes subir el diagrama del Proceso de Nivel 1',
            'documento.required' => 'Debes subir la ficha del Proceso de Nivel 1',
            'codigo_indicador.*.required' => 'Escriba el codigo del indicador del proceso',
            'descripcion_indicador.*.required' => 'Escriba el nombre del indicador del proceso',
            'codigo_procedimiento.*.required' => 'Escriba el codigo del procedimiento.',
            'descripcion_procedimiento.*.required' => 'Escriba el nombre del procedimiento'
        ]);
        
        return DB::transaction(function () use ($request) {
            $obj        = SGCProceso_uno::withTrashed()->find($request->id);

            if (empty($obj)) {
                /**--------REGISTRO PROCESO UNO */
                $obj = new SGCProceso_uno();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->version = $request->version;
                $obj->fecha_aprobado = $request->fecha_aprobado;
                $obj->idproceso_cero = $request->idproceso_cero;
                $obj->codigo = $request->codigo;
                $obj->descripcion = $request->descripcion;
                $obj->save();

                /**---------REGISTRO INDICADORES */
                for ($i = 0; $i < count($request->codigo_indicador); $i++) {
                    $indicador = new SGCIndicador_uno();
                    $indicador->idproceso_uno = $obj->id;
                    $indicador->idpersona_solicita = $request->idpersona_solicita;
                    $indicador->version_proceso_uno = $request->version;
                    $indicador->codigo = $request->codigo_indicador[$i];
                    $indicador->descripcion = $request->descripcion_indicador[$i];
                    $indicador->save();
                }

                /**------------REGISTRO PROCEDIMIENTOS */
                for ($i = 0; $i < count($request->codigo_procedimiento); $i++) {
                    $procedimiento = new SGCProcedimiento();
                    $procedimiento->idproceso_uno = $obj->id;
                    $procedimiento->idpersona_solicita = $request->idpersona_solicita;
                    $procedimiento->version_proceso_uno = $request->version;
                    $procedimiento->codigo = $request->codigo_procedimiento[$i];
                    $procedimiento->descripcion = $request->descripcion_procedimiento[$i];
                    $procedimiento->save();
                }

                return response()->json($obj);
            }

            /**---------VALIDA EL ESTADO PENDIENTE */
            /*if($obj->idestado == 1){
                $data = array(
                    "type" => "error",
                    "text" => "No puedes editar un registro que está en estado Pendiente"
                );
                return response()->json($data);
            }*/

            /**------EDITAR TABLA */
            $obj->idpersona_solicita = $request->idpersona_solicita;
            $obj->idpersona_aprueba = null;
            $obj->idtipo_accion = 2;
            $obj->idestado = 1;
            $obj->idpersona_solicita = $request->idpersona_solicita;
            $obj->version = $request->version;
            $obj->fecha_aprobado = $request->fecha_aprobado;
            $obj->idproceso_cero = $request->idproceso_cero;
            $obj->codigo = $request->codigo;
            $obj->descripcion = $request->descripcion;
            $obj->save();

            /**----------EDITAR O REGISTRAR INDICADOR */
            for ($i = 0; $i < count($request->codigo_indicador); $i++) {
                $indicador = SGCIndicador_uno::find($request->id_indicador[$i]);
                
                if(is_null($indicador))
                    $indicador = new SGCIndicador_uno();
                $indicador->idpersona_aprueba = null;
                $indicador->idtipo_accion = 2;
                $indicador->idestado = 1; 
                $indicador->idproceso_uno = $obj->id;
                $indicador->idpersona_solicita = $obj->idpersona_solicita;
                $indicador->version_proceso_uno = $obj->version;
                $indicador->codigo = $request->codigo_indicador[$i];
                $indicador->descripcion = $request->descripcion_indicador[$i];
                $indicador->save();
            }

            /**------------EDITAR O REGISTRAR PROCEDIMIENTO */
            for ($i = 0; $i < count($request->codigo_procedimiento); $i++) {
                $procedimiento = SGCProcedimiento::find($request->id_procedimiento[$i]);
                
                if(is_null($procedimiento))
                    $procedimiento = new SGCProcedimiento();
                $indicador->idpersona_aprueba = null;
                $indicador->idtipo_accion = 2;
                $indicador->idestado = 1; 
                $procedimiento->idproceso_uno = $obj->id;
                $procedimiento->idpersona_solicita = $obj->idpersona_solicita;
                $procedimiento->version_proceso_uno = $obj->version;
                $procedimiento->codigo = $request->codigo_procedimiento[$i];
                $procedimiento->descripcion = $request->descripcion_procedimiento[$i];
                $procedimiento->save();
            }
            
            return response()->json($obj);
        });
    }

    public function edit($id)
    {
        return view("{$this->path_controller}.form", $this->form($id));
    }

    public function ver($id)
    {
        return view("{$this->path_controller}.form_disabled", $this->form($id));
    }

    public function aprobar(request $request)
    {
        return DB::transaction(function () use($request){
            $obj = SGCProceso_uno::withTrashed()->find($request->id);

            /**-----------VALIDA EL ESTADO PENDIENTE */
            if($obj->idestado == 1){
                $obj->idpersona_aprueba = auth()->user()->persona->id;
                $obj->idestado = 2;
                $obj->save();
    
                /**----------REGISTRA EL MOVIMIENTO */
                $mov = new MOVSGCMov_proceso_uno();
                $mov->idestado = 2;
                $mov->idtipo_accion = $obj->idtipo_accion;
                $mov->idpersona_solicita = $obj->idpersona_solicita;
                $mov->idpersona_aprueba = auth()->user()->persona->id;
                $mov->idproceso_cero    = $obj->idproceso_cero;
                $mov->idsgc = $obj->id;
                $mov->version = $obj->version;
                $mov->fecha_aprobado = $obj->fecha_aprobado;
                $mov->codigo = $obj->codigo;
                $mov->descripcion = $obj->descripcion;
                $mov->diagrama = $obj->diagrama;
                $mov->documento = $obj->documento;
                $mov->save();

                /**------EDITAR EL INDICADOR */
                $indicador = SGCIndicador_uno::
                where('idproceso_uno', $obj->id)->where('version_proceso_uno', $obj->version)->get();
                
                foreach($indicador as $indi){
                    $indi->idpersona_aprueba = $obj->idpersona_aprueba;
                    $indi->idestado = 2;
                    $indi->save();

                    $mov_indi = new MOVSGCMov_indicador_uno();
                    $mov_indi->idestado = 2;
                    $mov_indi->idtipo_accion = $indi->idtipo_accion;
                    $mov_indi->idpersona_solicita = $indi->idpersona_solicita;
                    $mov_indi->idpersona_aprueba = $indi->idpersona_aprueba;
                    $mov_indi->idproceso_uno = $indi->idproceso_uno;
                    $mov_indi->version_proceso_uno = $indi->version_proceso_uno;
                    $mov_indi->codigo = $indi->codigo;
                    $mov_indi->descripcion = $indi->descripcion;
                    $mov_indi->idsgc = $indi->id;
                    $mov_indi->save();
                }

                /**------EDITAR EL PROCEDIMIENTO */
                $procedimiento = SGCProcedimiento::
                where('idproceso_uno', $obj->id)->where('version_proceso_uno', $obj->version)->get();

                foreach($procedimiento as $proc){
                    $proc->idpersona_aprueba = $obj->idpersona_aprueba;
                    $proc->idestado = 2;
                    $proc->save();

                    $mov_proc = new MOVSGCMov_procedimiento();
                    $mov_proc->idestado = 2;
                    $mov_proc->idtipo_accion = $proc->idtipo_accion;
                    $mov_proc->idpersona_solicita = $proc->idpersona_solicita;
                    $mov_proc->idpersona_aprueba = $proc->idpersona_aprueba;
                    $mov_proc->idproceso_uno = $proc->idproceso_uno;
                    $mov_proc->version_proceso_uno = $proc->version_proceso_uno;
                    $mov_proc->codigo = $proc->codigo;
                    $mov_proc->descripcion = $proc->descripcion;
                    $mov_proc->idsgc = $proc->id;
                    $mov_proc->save();
                }

                /**------ELIMINA EL REGISTRO */
                if($obj->idtipo_accion == 3)
                    $obj->delete();
                /**---------RESTAURA EL REGISTRO */
                if($obj->idtipo_accion == 4)
                    $obj->restore();                
            }
        
            return response()->json($obj);
        });
    }

    public function destroy(Request $request)
    {
        $obj = SGCProceso_uno::withTrashed()->where("id", $request->id)->first();

        /**---------VALIDA SI ESTA PENDIENTE */
        if($obj->idestado == 1){
            $data = array(
                "type" => "error",
                "text" => "No puedes ".$request->accion." un registro que está en estado Pendiente"
            );
            return response()->json($data);
        }
        /*if ($obj->procedimiento->isNotEmpty()) {
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel 1 " . $obj->descripcion . " tiene información dentro de si por lo cual no se puede eliminar."]);
        }*/
        
        /**-------------------SOLICITUD ELIMINAR----- */
        if ($request->accion == "eliminar") {
            $obj->idpersona_solicita = auth()->user()->persona->id;
            $obj->idtipo_accion = 3;
            $obj->idestado = 1;
            $obj->save();

            return response()->json($obj);
        }

        /**-----------------SOLICITUD RESTAURAR--- */
        $obj->idpersona_solicita = auth()->user()->persona->id;
        $obj->idtipo_accion = 4;
        $obj->idestado = 1;
        $obj->save();

        return response()->json($obj);        
    }
}
