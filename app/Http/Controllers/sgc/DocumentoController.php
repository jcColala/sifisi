<?php

namespace App\Http\Controllers\sgc;
use App\Http\Controllers\Controller;
use App\Models\COMCargo;
use App\Models\MOVSGCMov_entidad;
use App\Models\Funcion;
use App\Models\SGCDocumento;
use App\Models\SGCResolucion;
use App\Models\SGCEstado;
use App\Models\SGCTipo_documento;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;

class DocumentoController extends Controller
{
    public $modulo                  = "Documentos";
    public $path_controller         = "documentos";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public $dataTableServer         = null;

    public function __construct(){
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new SGCDocumento();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "";
        $datos["data"]              = [];
        $datos["entidades"]         = COMCargo::get();
        $datos["tipo_documentos"]   = SGCTipo_documento::get();
        $datos["resoluciones"]      = SGCResolucion::get();
        if( $id != null )
            $datos["data"]          = SGCDocumento::withTrashed()->find($id);
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }


    public function grilla(){
        $objeto = SGCDocumento::with('persona_solicita')->with('persona_aprueba')->with('estado')->with('tipo_accion')->withTrashed();
        
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
            'codigo'            =>'required',
            'descripcion'       =>'required|max:120',
            'version'           =>'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'fecha_emision'     =>'required',
            'fecha_aprobacion'  =>'required',
            'idtipo_documento'  =>'required',
            'identidad'         =>'required',
            'idresolucion'      =>'required',
            'porcentaje'        => 'required|integer',
            ],[
            'codigo.required'=>'Ingresar el código del documento',
            'descripcion.required'=>'Ingresar el nombre del documento',
            'version.required'=>'Ingresar el version del documento',
            'fecha_emision.required'=>'Ingresar la fecha de emisión del documento',
            'fecha_aprobacion.required'=>'Ingresar la fecha de aprobación del documento',
            'idtipo_documento.required'=>'Seleccionar el tipo del documento',
            'identidad.required'=>'Seleccionar la entidad del documento',
            'idresolucion.required'=>'Seleccionar la resolución asociada al documento',
            'porcentaje.required' => 'Ingresar la cantidad de integrantes de la entidad',
            'porcentaje.integer' => 'La cantidad de integrantes debe ser un número entero'
        ]);

        return DB::transaction(function() use ($request){            
            $obj = SGCDocumento::withTrashed()->find($request->id);
            
            if(empty($obj)){
                //TRATAMIENTO DEL DOCUMENTO
                $documento = $request->file('archivo');
                if (!Storage::putFileAs('documentos', $documento, $documento->getClientOriginalName())) {
                    $data = array(
                        "type" => "error",
                        "text" => "No se ha podido subir el documento, inténtelo nuevamente"
                    );
                    return response()->json($data);  
                }
                //REGISTRO EN TABLA
                $obj = new SGCDocumento();
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->idtipo_accion = 1;
                $obj->codigo = $request->codigo;
                $obj->descripcion = $request->descripcion;
                $obj->version   = $request->version;
                $obj->fecha_emision = $request->fecha_emision;
                $obj->fecha_aprobacion = $request->fecha_aprobacion;
                $obj->ubicacion_fisica = $request->ubicacion_fisica;
                $obj->idtipo_documento = $request->idtipo_documento;
                $obj->identidad        = $request->identidad;
                $obj->idresolucion     = $request->idresolucion;
                $obj->porcentaje       = $request->porcentaje;
                $obj->documento        = $documento->getClientOriginalName();   
                $obj->idtipo_archivo   = "1";
                $obj->save();

            }else{
                if($obj->idestado == 1){//VALIDA SI ESTÁ PENDIENTE
                    $data = array(
                        "type" => "error",
                        "text" => "No puedes editar un registro que está en estado Pendiente"
                    );
                    return response()->json($data);
                }
                $obj->idpersona_solicita = $request->idpersona_solicita;
                $obj->idtipo_accion = 1;
                $obj->codigo = $request->codigo;
                $obj->descripcion = $request->descripcion;
                $obj->version   = $request->version;
                $obj->fecha_emision = $request->fecha_emision;
                $obj->fecha_aprobacion = $request->fecha_aprobacion;
                $obj->ubicacion_fisica = $request->ubicacion_fisica;
                $obj->idtipo_documento = $request->idtipo_documento;
                $obj->identidad        = $request->identidad;
                $obj->idresolucion     = $request->idresolucion;
                $obj->porcentaje       = $request->porcentaje;
                $obj->documento        = "a";   
                $obj->idtipo_archivo   = "1";
                $obj->save();
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
        $obj = SGCDocumento::withTrashed()->where("id",$request->id)->first();
        $obj->idpersona_aprueba = auth()->user()->persona->id;
            $obj->idestado = 2;
            $obj->save();
            return response()->json($obj);
    }
    
    public function destroy(Request $request){

        $obj = SGCDocumento::withTrashed()->where("id",$request->id)->first();
        /*if($obj->modulo->isNotEmpty()){
            throw ValidationException::withMessages(["referencias" => "El Proceso de Nivel Cero ".$obj->descripcion." tiene información dentro de si por lo cual no se puede eliminar."]);
        }*/
        
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

            //EDICIÓN EN MOVIMIENTO
            $obj_mov = new MOVSGCMov_entidad();
            $obj_mov->idpersona_solicita = auth()->user()->persona->dni;
            $obj_mov->idtipo_accion = 3;
            $obj_mov->idsgc = $obj->id;
            $obj_mov->save();
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
