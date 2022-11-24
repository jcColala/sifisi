<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class Modulo_padre extends Model
{
    use SoftDeletes;

    protected $table        = "seguridad.modulo_padre";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'abreviatura',
        'url',
        'icono',
        'orden',
        'editable',
        'deleted_at'
    ];

    public function modulo(){
        return $this->hasMany(Modulo::class,'idmodulo_padre');
    }

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }

    public function getModulo($modulo, $idpadre=''){

        return collect($modulo)
            ->where('idpadre',$idpadre)
            ->map(function($item) use ($modulo){
                $value                      = [];
                $value['id']                = $item->id;
                $value['idpadre']           = $item->idpadre;
                $value['text']              = $item->modulo;
                $value['abreviatura']       = $item->abreviatura;
                $value['acceso_directo']    = ($item->acceso_directo=="S");
                $value['icon']              = $item->icono;
                $value['url']               = $item->url;
                $value['submenu']           = $this->getModulo($modulo,$item->id);
                return $value;
            })->values()->all();

    }

    public function scopeAccesoModulos($query){
        $idperfil   = auth()->user()->perfil->id;
        $idrol      = DB::table("seguridad.usuario_role")->where('model_id',auth()->user()->id)->first()->role_id;
        
        return $query->with(['modulo'=>function($q) use ($idperfil, $idrol){
            $q->join('seguridad.accesos','accesos.idmodulo','=','modulo.id');
            $q->where('accesos.idperfil',$idperfil);
            $q->where('accesos.idrol',$idrol);
            $q->whereNull('accesos.deleted_at');
            $q->orderBy("modulo.idpadre");
            $q->orderBy("modulo.orden");
        }]);
    }

    public static function menu(){
        $modulo_padre  = static::accesoModulos()->selectRaw('id, descripcion, icono')->orderBy('orden')->get();
        $menus         = [];

        foreach($modulo_padre as $item){
            if($item->modulo->count()){
                $value                  = [];
                $value['text']          = $item->descripcion;
                $value['icono']         = $item->icono;
                $value['submenu']       = $item->getModulo($item->modulo, null);
                $menus[]                = $value;
            }
        }
        return $menus;
    }

    public function getComprobarAcesoModulo($idmodulo = null, $idperfil = null){
        $query  = Accesos::where('idmodulo',$idmodulo)->where('idperfil',$idperfil)->first();
        if ($query)
            return true;
        return false;
    }

    public function getComprobarPermiso($url = null, $funcion = null, $idrol = null){
        $query  = Permission::select('r_p.*')
                    ->join('seguridad.role_permisos as r_p','seguridad.permisos.id','=','r_p.permission_id')
                    ->where('seguridad.permisos.name',$funcion."-".$url)
                    ->where('r_p.role_id',$idrol)->first();
        if ($query)
            return true;
        return false;
    }

    public function getTraerFunciones($idmodulo = null,$url = null, $idrol = null, $idperfil = null){
        $children = [];
        $funcion = Funcion_modulo::with('funcion')->where("idmodulo",$idmodulo)->get();
        foreach ($funcion as $key => $item) {
                $value                          = [];
                $value['id']                    = "f-".$idmodulo."-".$item["funcion"]->funcion;
                $value['text']                  = $item["funcion"]->nombre;
                if ($item["funcion"]->icono == null) {
                    $value['icon']              = "fe fe-code";
                }else{
                    $value['icon']              = $item["funcion"]->icono;
                }
                if ($idrol != null){
                    $value['state']['selected'] = $this->getComprobarPermiso($url,$item["funcion"]->funcion,$idrol);
                    $value['state']['opened']   = $this->getComprobarPermiso($url,$item["funcion"]->funcion,$idrol);
                }
                $children[]                     = $value;
        }
        return $children;
    }

    public function getTraerModulos($modulo, $idpadre = null, $idperfil = null, $idrol = null){
        return collect($modulo)
            ->where('idpadre',$idpadre)
            ->map(function($item) use ($modulo,$idpadre,$idperfil,$idrol){
                $value                          = [];
                $value['id']                    = "m-".$item->id;
                $value['text']                  = $item->modulo;
                if ($idrol != null){
                    //$value['state']['selected'] = $this->getComprobarAcesoModulo($item->id,$idperfil);
                    $value['state']['opened']   = $this->getComprobarAcesoModulo($item->id,$idperfil);
                }
                if($this->getTraerModulos($modulo,$item->id,$idperfil) == null){
                    $value['children']          = $this->getTraerFunciones($item->id,$item->url,$idrol,$idperfil);
                }else{
                    $value['children']          = $this->getTraerModulos($modulo,$item->id,$idperfil,$idrol);
                }

                return $value;
            })->values()->all();

    }

    public static function acceso_modulos($idmodulo_padre, $idperfil, $idrol){
        $query  = static::with('modulo')->where('id',$idmodulo_padre)->orderBy('orden')->get();
        $data   = [];

        foreach($query as $item){
                $value                      = [];
                $value['id']                = "p-".$item->id;
                $value['text']              = $item->descripcion;
                $value['icon']              = $item->icono;
                $value['state']['opened']   = true;
                $value['children']          = $item->getTraerModulos($item->modulo,null,$idperfil,$idrol);
                $data[]                     = $value;
        }

        if(count($data) == 1)
            if (count($data[0]["children"]) == 0)
                return [];
        return $data;
    }
}
