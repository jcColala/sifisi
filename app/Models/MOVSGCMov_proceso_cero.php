<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MOVSGCMov_proceso_cero extends Model
{
    use SoftDeletes;

    protected $table        = "movsgc.mov_proceso_cero";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idtipo_proceso',
        'idresponsable',
        'codigo',
        'descripcion',
        'version',
        'fecha_aprobado',
        'objetivo',
        'alcance',
        'deleted_at'
    ];

    /*
    public function procesos_uno(){
        return $this->hasMany(MOVSGCMov_proceso_uno::class);
    }

    public function tipo_proceso(){
        return $this->belongsTo(SGCTipo_proceso::class, 'idtipo_proceso');
    }

    public function responsable(){
        return $this->belongsTo(SGCEntidad::class, 'idresponsable');
    }*/

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
