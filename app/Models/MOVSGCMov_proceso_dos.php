<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MOVSGCMov_proceso_dos extends Model
{
    use SoftDeletes;

    protected $table        = "movsgc.mov_proceso_dos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idtipo_accion',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idproceso_cero',
        'idsgc',
        'codigo',
        'descripcion',
        'version',
        'fecha_aprobado',
        'objetivo',
        'alcance',
        'proveedores',
        'entradas',
        'clientes',
        'salidas',
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
