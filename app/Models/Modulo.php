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
        "editable",
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
}
