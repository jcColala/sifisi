<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MOVSGCMov_entidad_integrantes extends Model
{
    use SoftDeletes;

    protected $table        = "movsgc.mov_entidad_integrantes";
    protected $primaryKey   = "id";

    protected $fillable = [
        'identidad',
        'idusuario_solicita',
        'idusuario_aprueba',
        'idestado',
        'idintegrante',
        'descripcion',
        'deleted_at'
    ];
    

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
