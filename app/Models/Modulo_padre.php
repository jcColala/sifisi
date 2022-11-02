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
}
