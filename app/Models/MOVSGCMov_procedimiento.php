<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MOVSGCMov_procedimiento extends Model
{
    use SoftDeletes;

    protected $table        = "movsgc.mov_procedimiento";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idtipo_accion',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idproceso_uno',
        'idsgc',
        'codigo',
        'descripcion',
        'version',
        'version_proceso_uno',
        'fecha_aprobado',
        'documento',
        'diagrama',
        'editable',
        'deleted_at'
    ];
    
    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
