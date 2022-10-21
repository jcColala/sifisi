<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modulo extends Model{
    use SoftDeletes;

    protected $table        = "seguridad.modulo";
    protected $primaryKey   = "id";

    protected $fillable     = [
        "idmodulo_padre",
        "idpadre",
        "modulo",
        "abreviatura",
        "url",
        "icono",
        "orden",
        "acceso_directo",
        "deleted_at"
    ];

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }

    public function padre(){
        return $this->belongsTo(Modulo_padre::class,'idmodulo_padre');
    }

    public function modulopadre(){
        return $this->belongsTo(Modulo::class,'idpadre');
    }

    /*public function AccesoModulo(){
        return $this->hasMany(Accesos::class,'codmodulos');
    }

    public function scopeWithBotones($query){
        return $query->with(['botones'=>function($q){
            $q->Join('seguridad.boton as b','b.codboton','detalle_boton.codboton')
                ->selectRaw(
                  'detalle_boton.codmodulos,
                   detalle_boton.coddetalle_boton,
                   b.codboton,
                   detalle_boton.coddetalle_boton,
                   detalle_boton.coddetalle_boton,
                   b.descripcion as  boton,
                   b.descripcion as text,
                   b.icono,
                   b.orden,
                   b.clase_name as clase,
                   b.codboton as id,
                   detalle_boton.codmodulos
                   '
                )
                ->orderBy('b.orden');
        }]);
    }

    public function scopeAccesoRapido($query, $limit=""){
        $codperfil      = auth()->user()->sucursal()->codperfil;
        $codsucursal    = auth()->user()->sucursal()->codsucursal;

        return $query->with(["AccesoModulo"=>function($q) use ($codperfil, $codsucursal){
            $q->selectRaw("*");
            $q->where("accesos.codperfil", $codperfil);
            $q->where("accesos.codsucursal", $codsucursal);
        }])
        ->where("modulos.acceso_directo", "S")
        ->whereNotNull("modulos.url")
        ->when($limit, function($sq, $limit){
            $sq->limit($limit);
        });
    }*/
}
