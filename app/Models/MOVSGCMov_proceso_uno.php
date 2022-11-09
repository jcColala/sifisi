<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MOVSGCMov_proceso_uno extends Model
{
    use SoftDeletes;

    protected $table        = "movsgc.mov_proceso_uno";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idproceso_cero',
        'idelaborado',
        'idrevisado',
        'idaprobado',
        'codigo',
        'descripcion',
        'version',
        'fecha_aprobado',
        'proveedores',
        'entradas',
        'salidas',
        'clientes',
        'diagrama',
        'deleted_at'
    ];


    public function proceso_cero(){
        return $this->belongsTo(SGCProceso_cero::class, 'idproceso_cero');
    }
    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}