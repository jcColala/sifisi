<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Funcion;
use App\Models\Perfil;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public $modulo                  = "Usuario";
    public $path_controller         = "usuario";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";
    public $paht_file               = null;

    public function __construct(){

        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new user();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();
        $this->paht_file            = (new User())->getPathFile();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "usuario";
        $datos["perfil"]            = Perfil::get();
        $datos["role"]              = Role::get();
        $datos["data"]              = [];
        if( $id != null ){
            $datos["data"]                      = User::withTrashed()->with('persona')->find($id);
            $datos["data"]["rol"]               = User::withTrashed()->find($id)->roles->first()["id"];
            $datos["data"]["persona_nombres"]   = $datos["data"]["persona"]["apellido_paterno"]." ".$datos["data"]["persona"]["apellido_materno"]." ".$datos["data"]["persona"]["nombres"];
        }
        return $datos;
    }

    public function form_reset($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "usuario";
        $datos["data"]              = [];
        if( $id != null ){
            $datos["data"]                      = User::withTrashed()->with('persona')->find($id);
            $datos["data"]["persona_nombres"]   = $datos["data"]["persona"]["apellido_paterno"]." ".$datos["data"]["persona"]["apellido_materno"]." ".$datos["data"]["persona"]["nombres"];
        }
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function grilla(){
        $objeto = User::Select("seguridad.usuario.*")->with('persona')->withTrashed();
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
        $this->validate($request,[
            'idpersona' => 'required',
            'idperfil' => 'required',
            'rol' => 'required',
            'usuario' =>['required',
                          'max:60',
                          Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "usuario")
                          ->ignore($request->id, "id")
                        ],
            'password' => ['required_without:id', 'confirmed',],
        ],[
            "idpersona.required"=>"El campo persona es obligatorio.",
            "idperfil.required"=>"El campo perfil es obligatorio.",
            "rol.required"=>"El campo rol es obligatorio.",
            "password.required_without"=>"El campo password es obligatorio.",
            "password.confirmed"=>"Las passwords no coinciden."
        ]);

        return DB::transaction(function() use ($request){
            $file_name = $request->avatar_nombre;
            if($request->hasFile('avatar')){
                $file_paht  = $request->file("avatar");
                $file_name  = $_FILES['avatar']['name'];
                $extencion  = $file_paht->guessExtension();

                if ($extencion == "jpg" OR $extencion == "png" OR $extencion == "jpeg" OR $extencion == "svg"){
                    copy($file_paht->getRealPath(),$this->paht_file.$file_name);
                }else{
                    throw ValidationException::withMessages(['invalide_img' => "Formato de imagen no válido, seleccione otra imagen."]);
                }
            }

            $obj            = User::withTrashed()->find($request->id);
            $password       = null;
            if(is_null($obj)){
                $obj        = new User();
                $password   = Hash::make($request->password);
            }else{
                DB::table('seguridad.usuario_role')->where('model_id',$request->id)->delete();
            }
            $obj->fill($request->all());
            if(!is_null($password))
                $obj->password = $password;
            $obj->avatar = $file_name;
            $obj->save();
            $obj->assignRole($request->rol);

            return response()->json($obj);
        });
        
    }

    public function store_reset(Request $request){
        $this->validate($request,[
            'password' => ['required', 'confirmed']
        ],[
            "password.required"=>"El campo password es obligatorio.",
            "password.confirmed"=>"Las passwords no coinciden."
        ]);

        $obj            = User::withTrashed()->find($request->id);
        if(is_null($obj)){
            throw ValidationException::withMessages(['usuario_required' => 'Usuario no existente.']);
        }else{
            $password   = Hash::make($request->password);
            $obj->password = $password;
            $obj->save();
        }
        return response()->json($obj);

    }

    public function edit($id){
        return view("{$this->path_controller}.form",$this->form($id));
    }

    public function reset($id){
        return view("{$this->path_controller}.reset",$this->form_reset($id));
    }

    public function destroy(Request $request){

        if ($request->accion == "eliminar") {
            User::find($request->id)->delete();
            return response()->json();
        }
        User::withTrashed()->find($request->id)->restore();
        return response()->json();        
    }
}
