<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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
                $value['submenu']           =$this->getModulo($modulo,$item->id);
                return $value;
            })->values()->all();

    }

    public function scopeAccesoModulos($query){
        $idperfil   = auth()->user()->perfil->id;

        return $query->with(['modulo'=>function($q) use ($idperfil){
            $q->join('seguridad.accesos','accesos.idmodulo','=','modulo.id');
            $q->where('accesos.idperfil',$idperfil)
            ->where('accesos.acceder',1);
            $q->orderBy("modulo.idpadre");
            $q->orderBy("modulo.orden");
        }]);
    }

    public static function menu(){
        $modulo_padre   = static::accesoModulos()
                            ->selectRaw('id, descripcion, icono')
                            ->orderBy('orden')
                            ->get();
        $menus  = [];
        foreach($modulo_padre as $item){
            if($item->modulo->count()){
                $value                  = [];
                $value['text']          = $item->descripcion;
                $value['icono']         = $item->icono;
                $value['submenu']       = $item->getModulo($item->modulo, null);
                $menus[]                = $value;
            }
        }
        //dd($menus);
        return $menus;
    }
}
