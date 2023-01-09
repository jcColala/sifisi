<?php

namespace App\Http\Controllers\sgc;

use App\Http\Controllers\Controller;


use App\Models\COMComisiones;
use App\Models\SGCProceso_cero;
use App\Models\SGCProceso_uno;
use App\Models\MOVSGCMov_proceso_uno;
use App\Models\SGCTipo_proceso;
use App\Models\SGCIndicador_uno;
use App\Models\MOVSGCMov_indicador_uno;
use App\Models\SGCProcedimiento;

use App\Models\Funcion;
use App\Models\MOVSGCMov_procedimiento;
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
            $datos["indicadores"]   = SGCIndicador_uno::where('idproceso_uno', $id)->orderBy('id')->get();
        if ($id != null)
            $datos["procedimientos"] = SGCProcedimiento::where('idproceso_uno', $id)->orderBy('id')->get();
        return $datos;
    }

    public function index()
    {
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla()
    {
        //withTrashed
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
            'codigo_indicador' => 'required',
            'descripcion_indicador' => 'required',
            'codigo_procedimiento' => 'required',
            'descripcion_procedimiento' => 'required',

        ], [
            'version.required' => 'Escriba la versión del documento',
            'fecha_aprobado.required' => 'Seleccione la fecha en la que se aprobó el documento',
            'idproceso_cero.required' => 'Seleccione el Proceso Nivel Cero al que pertenece este Proceso Nivel 1',
            'descripcion.required' => 'Escriba el Nombre del Proceso',
            'diagrama.required' => 'Debes subir el diagrama del Proceso de Nivel 1',
            'documento.required' => 'Debes subir la ficha del Proceso de Nivel 1',
            'codigo_indicador.required' => 'Escriba el codigo del indicador del proceso',
            'descripcion_indicador.required' => 'Escriba el nombre del indicador del proceso',
            'codigo_procedimiento.required' => 'Escriba el codigo del procedimiento.',
            'descripcion_procedimiento.required' => 'Escriba el nombre del procedimiento'
        ]);
        
        return DB::transaction(function () use ($request) {
            $obj        = SGCProceso_uno::withTrashed()->find($request->id);
            if (empty($obj)) {
                /**-----------REGISTRO ---------------- */
                //TABLA PROCESO UNO
                $obj = new SGCProceso_uno();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->version = $request->version;
                $obj->fecha_aprobado = $request->fecha_aprobado;
                $obj->idproceso_cero = $request->idproceso_cero;
                $obj->codigo = $request->codigo;
                $obj->descripcion = $request->descripcion;
                $obj->save();

                //MOVIMIENTO PROCESO UNO
                $mov = new MOVSGCMov_proceso_uno();
                $mov->idpersona_solicita = $request->idpersona_solicita;
                $mov->version = $request->version;
                $mov->fecha_aprobado = $request->fecha_aprobado;
                $mov->idproceso_cero = $request->idproceso_cero;
                $mov->idsgc = $obj->id;
                $mov->codigo = $request->codigo;
                $mov->descripcion = $request->descripcion;
                $mov->save();


                //TABLA INDICADOR 
                for ($i = 0; $i < count($request->codigo_indicador); $i++) {
                    $indicador = new SGCIndicador_uno();
                    $indicador->idproceso_uno = $obj->id;
                    $indicador->idpersona_solicita = $request->idpersona_solicita;
                    $indicador->version_proceso_uno = $request->version;
                    $indicador->codigo = $request->codigo_indicador[$i];
                    $indicador->descripcion = $request->descripcion_indicador[$i];
                    $indicador->save();

                    $mov = new MOVSGCMov_indicador_uno();
                    $mov->idproceso_uno = $obj->id;
                    $mov->idpersona_solicita = $request->idpersona_solicita;
                    $mov->idsgc = $indicador->id;
                    $mov->version_proceso_uno = $request->version;
                    $mov->codigo = $request->codigo_indicador[$i];
                    $mov->descripcion = $request->descripcion_indicador[$i];
                    $mov->save();
                }

                //TABLA PROCEDIMIENTO 
                for ($i = 0; $i < count($request->codigo_procedimiento); $i++) {
                    $procedimiento = new SGCProcedimiento();
                    $procedimiento->idproceso_uno = $obj->id;
                    $procedimiento->idpersona_solicita = $request->idpersona_solicita;
                    $procedimiento->version_proceso_uno = $request->version;
                    $procedimiento->codigo = $request->codigo_procedimiento[$i];
                    $procedimiento->descripcion = $request->descripcion_procedimiento[$i];
                    $procedimiento->save();

                    $mov = new MOVSGCMov_procedimiento();
                    $mov->idproceso_uno = $obj->id;
                    $mov->idpersona_solicita = $request->idpersona_solicita;
                    $mov->idsgc = $procedimiento->id;
                    $mov->version_proceso_uno = $request->version;
                    $mov->codigo = $request->codigo_procedimiento[$i];
                    $mov->descripcion = $request->descripcion_procedimiento[$i];
                    $mov->save();
                }
            } else {
                if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
                    $data = array(
                        "type" => "error",
                        "text" => "No puedes editar un registro que está en estado Pendiente"
                    );
                    return response()->json($data);
                }
                /** -------------------EDICION---------- */
                //EDICIÓN TABLA
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->idpersona_aprueba = null;
                $obj->idtipo_accion = 2;
                $obj->idestado = 1;
                $obj->save();

                $mov = new MOVSGCMov_proceso_uno();
                $mov->idpersona_solicita = $request->idpersona_solicita;
                $mov->idestado = 1;
                $mov->idtipo_accion = 2;
                $mov->version = $request->version;
                $mov->fecha_aprobado = $request->fecha_aprobado;
                $mov->idproceso_cero = $request->idproceso_cero;
                $mov->idsgc = $obj->id;
                $mov->codigo = $request->codigo;
                $mov->descripcion = $request->descripcion;
                $mov->save();
                
                //ELIMINA LOS INDICADORES DEL PROCESO
                SGCIndicador_uno::where('idproceso_uno', $obj->id)->delete();
                MOVSGCMov_indicador_uno::where('idproceso_uno')->delete();

                //REGISTRO O EDICIÓN DE INDICADORES AL EDITAR
                for ($i = 0; $i < count($request->codigo_indicador); $i++){
                    $indicador  = SGCIndicador_uno::withTrashed()->find($request->id_indicador[$i]);

                    if (is_null($indicador)){//REGISTRA UN NUEVO INDICADOR
                        $indicador = new SGCIndicador_uno();
                        $indicador->idproceso_uno = $obj->id;
                        $indicador->idpersona_solicita = $request->idpersona_solicita;
                        $indicador->version_proceso_uno = $request->version;
                        $indicador->codigo = $request->codigo_indicador[$i];
                        $indicador->descripcion = $request->descripcion_indicador[$i];
                        $indicador->save();
    
                        $mov = new MOVSGCMov_indicador_uno();
                        $mov->idproceso_uno = $obj->id;
                        $mov->idpersona_solicita = $request->idpersona_solicita;
                        $mov->idsgc = $indicador->id;
                        $mov->version_proceso_uno = $request->version;
                        $mov->codigo = $request->codigo_indicador[$i];
                        $mov->descripcion = $request->descripcion_indicador[$i];
                        $mov->save();
                    }else{
                        //RESTAURA LOS INDICADORES QUE SIGAN IGUALES
                        $indicador->restore();

                        //EDITA UN INDICADOR
                        $indicador->idpersona_solicita = $request->idpersona_solicita;
                        $indicador->idpersona_aprueba = null;
                        $indicador->idtipo_accion = 2;
                        $indicador->idestado = 1;
                        $indicador->save();    

                        //REGISTRO DE EDICIÓN EN LA TABLA MOVIMIENTO
                        $mov = new MOVSGCMov_indicador_uno();
                        $mov->idtipo_accion = 2;
                        $mov->idproceso_uno = $obj->id;
                        $mov->idpersona_solicita = $request->idpersona_solicita;
                        $mov->idsgc = $indicador->id;
                        $mov->version_proceso_uno = $request->version;
                        $mov->codigo = $request->codigo_indicador[$i];
                        $mov->descripcion = $request->descripcion_indicador[$i];
                        $mov->save();
                    }
                    
                }


                //ELIMINA LOS PROCEDIMIENTOS DEL PROCESO
                SGCProcedimiento::where('idproceso_uno', $obj->id)->delete();
                MOVSGCMov_procedimiento::where('idproceso_uno')->delete();

                //REGISTRO O EDICIÓN DE PROCEDIMIENTOS AL EDITAR
                for ($i = 0; $i < count($request->codigo_procedimiento); $i++) {
                    $procedimiento  = SGCProcedimiento::withTrashed()->find($request->id_procedimiento[$i]);

                    if (is_null($procedimiento)) { //REGISTRA UN NUEVO PROCEDIMIENTO
                        $procedimiento = new SGCProcedimiento();
                        $procedimiento->idproceso_uno = $obj->id;
                        $procedimiento->idpersona_solicita = $request->idpersona_solicita;
                        $procedimiento->version_proceso_uno = $request->version;
                        $procedimiento->codigo = $request->codigo_procedimiento[$i];
                        $procedimiento->descripcion = $request->descripcion_procedimiento[$i];
                        $procedimiento->save();

                        $mov = new MOVSGCMov_procedimiento();
                        $mov->idproceso_uno = $obj->id;
                        $mov->idpersona_solicita = $request->idpersona_solicita;
                        $mov->idsgc = $procedimiento->id;
                        $mov->version_proceso_uno = $request->version;
                        $mov->codigo = $request->codigo_procedimiento[$i];
                        $mov->descripcion = $request->descripcion_procedimiento[$i];
                        $mov->save();
                    } else {
                        //RESTAURA LOS PROCEDIMIENTOS QUE SIGAN IGUALES
                        $procedimiento->restore();

                        //EDITA UN PROCEDIMIENTO
                        $procedimiento->idpersona_solicita = $request->idpersona_solicita;
                        $procedimiento->idpersona_aprueba = null;
                        $procedimiento->idtipo_accion = 2;
                        $procedimiento->idestado = 1;
                        $procedimiento->save();

                        //REGISTRO DE EDICIÓN EN LA TABLA MOVIMIENTO
                        $mov = new MOVSGCMov_procedimiento();
                        $mov->idtipo_accion = 2;
                        $mov->idproceso_uno = $obj->id;
                        $mov->idpersona_solicita = $request->idpersona_solicita;
                        $mov->idsgc = $procedimiento->id;
                        $mov->version_proceso_uno = $request->version;
                        $mov->codigo = $request->codigo_procedimiento[$i];
                        $mov->descripcion = $request->descripcion_procedimiento[$i];
                        $mov->save();
                    }
                }
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
            //EDITA EL MOVIMIENTO
            $mov = MOVSGCMov_proceso_uno::where('idsgc', $request->id)->latest('created_at')->first();

            //SI EL ESTADO NO ESTA EN PENDIENTE NO HACE NADA
            if($mov->idestado == 2){
                return response()->json($mov);
            }
            
            $mov->idpersona_aprueba = auth()->user()->persona->id;
            $mov->idestado = 2;
            $mov->save();

            //APRUEBA EN LA TABLA
            $obj = SGCProceso_uno::where("id",$request->id)->first();
            $obj->idestado = 2;
            $obj->idtipo_accion = $mov->idtipo_accion;
            $obj->idpersona_solicita = $mov->idpersona_solicita;
            $obj->idpersona_aprueba = auth()->user()->persona->id;
            $obj->idproceso_cero    = $mov->idproceso_cero;
            $obj->version = $mov->version;
            $obj->fecha_aprobado = $mov->fecha_aprobado;
            $obj->codigo = $mov->codigo;
            $obj->descripcion = $mov->descripcion;
            $obj->diagrama = $mov->diagrama;
            $obj->documento = $mov->documento;

            $obj->save();

            //ELIMINAR EN MOVIMIENTO
            if($mov->idtipo_accion == 3){
                $mov->delete();
            }
            //RESTAURAR EN MOVIMIENTO
            if($mov->idtipo_accion == 4){
                $mov->restore();
            }            
            //ELIMINAR EN LA TABLA
            if($obj->idtipo_accion == 3)
                $obj->delete();

            //RESTAURAR EN LA TABLA
            if($obj->idtipo_accion == 4)
                $obj->restore();
            return response()->json($obj);
        });
    }

    public function destroy(Request $request)
    {
        $obj = SGCProceso_uno::withTrashed()->where("id", $request->id)->first();
        if ($obj->procesos_dos->isNotEmpty()) {
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel 1 " . $obj->descripcion . " tiene información dentro de si por lo cual no se puede eliminar."]);
        }
        /**-----------------------ELIMINAR --------------- */
        if ($request->accion == "eliminar") {
            if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
                $data = array(
                    "type" => "error",
                    "text" => "No puedes eliminar un registro que está en estado Pendiente"
                );
                return response()->json($data);
            }
            $obj->idpersona_solicita = auth()->user()->persona->id;
            $obj->idtipo_accion = 3;
            $obj->idestado = 1;
            $obj->save();

            $mov = new MOVSGCMov_proceso_uno();
            $mov->idpersona_solicita = $obj->idpersona_solicita;
            $mov->idestado = 1;
            $mov->idtipo_accion = 3;
            $mov->version = $obj->version;
            $mov->fecha_aprobado = $obj->fecha_aprobado;
            $mov->idproceso_cero = $obj->idproceso_cero;
            $mov->idsgc = $obj->id;
            $mov->codigo = $obj->codigo;
            $mov->descripcion = $obj->descripcion;
            $mov->save();

            return response()->json();
        }

        /**-------------------RESTAURAR------------------- */

        /**----------------------SOLICITUD RESTAURAR---------------------- */
        if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
            $data = array(
                "type" => "error",
                "text" => "No puedes restaurar un registro que está en estado Pendiente"
            );
            return response()->json($data);
        }
        $obj->idpersona_solicita = auth()->user()->persona->id;
        $obj->idtipo_accion = 4;
        $obj->idestado = 1;
        $obj->save();
        
        //MOVIMIENTO
        $mov = new MOVSGCMov_proceso_uno();
            $mov->idpersona_solicita = $obj->idpersona_solicita;
            $mov->idestado = 1;
            $mov->idtipo_accion = 4;
            $mov->version = $obj->version;
            $mov->fecha_aprobado = $obj->fecha_aprobado;
            $mov->idproceso_cero = $obj->idproceso_cero;
            $mov->idsgc = $obj->id;
            $mov->codigo = $obj->codigo;
            $mov->descripcion = $obj->descripcion;
            $mov->save();
        return response()->json($obj);   
    }
}
