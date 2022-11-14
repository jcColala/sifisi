<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCProceso_uno_detalle extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.proceso_uno_detalle";
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

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
