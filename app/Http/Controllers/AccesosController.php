<?php

namespace App\Http\Controllers;

use App\Models\Accesos;
use App\Models\Modulo;
use App\Models\Modulo_padre;
use App\Models\Perfil;
use App\Models\Funcion;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; 

use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AccesosController extends Controller
{
    public $modulo                  = "Accesos";
    public $path_controller         = "accesos";

    public $model                   = null;
    public $name_schema             = null;
    public $name_table              = "";

    public function __construct(){

        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:'.$value["funcion"].'-'.$this->path_controller.'', ['only' => [$value["funcion"]]]);
        }

        $this->model                = new Accesos();
        $this->name_schema          = $this->model->getSchemaName();
        $this->name_table           = $this->model->getTableName();

    }

    public function form($id = null){
        $datos["table_name"]        = $this->name_table;
        $datos["pathController"]    = $this->path_controller;
        $datos["modulo"]            = $this->modulo;
        $datos["prefix"]            = "accesos";
        $datos["modulo_padre"]      = Modulo_padre::get();
        $datos["perfil"]            = Perfil::get();
        $datos["role"]              = Role::get();
        return $datos;
    }

    public function index(){
        return view("{$this->path_controller}.index", $this->form());
    }

    public function acceso(Request $request){
        return response()->json((new Modulo_padre)->acceso_modulos($request->idmodulo_padre, $request->idperfil, $request->idrol));
    }

    public function store(Request $request){
        
        $this->validate($request,[
            "idmodulo_padre"=>"required",
            "idperfil"=>"required",
            "idrol"=>"required"
        ],[
            "idmodulo_padre.required"=>"El campo modulo padre es obligatorio.",
            "idperfil.required"=>"El campo perfil es obligatorio.",
            "idrol.required"=>"El campo rol es obligatorio."
        ]);

        return DB::transaction(function() use ($request){

            $array_mdpermisos   = [];
            foreach (Modulo::get() as $modulos) {
                foreach (Funcion::get() as $key => $funciones) {
                    $validar = Permission::where("name",$funciones["funcion"]."-".$modulos["url"])
                                ->join("seguridad.role_permisos as r_p","r_p.permission_id","id")
                                ->where("r_p.role_id",$request->idrol)
                                ->count();
                    if ($validar == 1)
                        $array_mdpermisos[$modulos["id"]][$funciones["funcion"]] = ["funcion" => $funciones["funcion"]."-".$modulos["url"]];
                }
            }

            if($request->filled("accesos_true") OR $request->filled("accesos_false")){
                
                $idmodulo_ant = 0;
                if ($request->filled("accesos_false")) {
                    foreach($request->accesos_false as $key => $value){
                        $ids = explode("-", $value["id"]);
                        $idmodulo = $ids[1];
                        $funcion  = $ids[2];
                        Accesos::where("idperfil",$request->idperfil)->where("idmodulo",$idmodulo)->where("idrol",$request->idrol)->delete();

                        if (array_key_exists($idmodulo, $array_mdpermisos)){
                            if ($idmodulo != $idmodulo_ant) {
                                unset($array_mdpermisos[$idmodulo]["index"]);
                                unset($array_mdpermisos[$idmodulo]["store"]);
                            }
                            unset($array_mdpermisos[$idmodulo][$funcion]);
                        }

                    }
                }

                $idmodulo_ant = 0;
                if ($request->filled("accesos_true")) {
                    foreach($request->accesos_true as $key => $value){
                        $ids = explode("-", $value["id"]);
                        $idmodulo = $ids[1];
                        $funcion  = $ids[2];

                        $obj = Accesos::withTrashed()->where("idperfil",$request->idperfil)->where('idmodulo',$idmodulo)->where("idrol",$request->idrol)->first();
                        if(is_null($obj))
                            $obj    = new Accesos();
                        $obj->idmodulo                          = $idmodulo;
                        $obj->idperfil                          = $request->idperfil;
                        $obj->idrol                             = $request->idrol;
                        $obj->deleted_at                        = null;
                        if ($obj->save()){
                            $modulo = Modulo::find($idmodulo);
                            if ($idmodulo != $idmodulo_ant) {
                                $array_mdpermisos[$idmodulo]["index"] = ["funcion" => "index-".$modulo["url"]];
                                $array_mdpermisos[$idmodulo]["store"] = ["funcion" => "store-".$modulo["url"]];
                                
                            }
                            $array_mdpermisos[$idmodulo][$funcion] = ["funcion" => $funcion."-".$modulo["url"]];
                            $idmodulo_ant = $idmodulo;
                        }
                    }
                    
                }

                $array_funcion = [];
                if (count($array_mdpermisos) > 0) {
                    foreach($array_mdpermisos as $key => $value){
                        $cont = 0;
                        foreach($value as $funcion) {
                            $validar = Permission::where("name",$funcion["funcion"])->count();
                            if($validar == 0)
                                Permission::create(['name'=>$funcion["funcion"]]);
                            array_push($array_funcion, $funcion["funcion"]);
                            $cont++;
                        }
                    }
                    $role = Role::find($request->idrol);
                    $role->syncPermissions($array_funcion);
                }
                return response()->json($request);

            }else{
                throw ValidationException::withMessages(['accesos' => 'Lista de accesos vacia.']);
            }
        });
    }
}
