<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCProceso_cero extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.proceso_cero";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idtipo_proceso',
        'idcargo_responsable',
        'idcargo_elaborado',
        'idcargo_revisado',
        'idcargo_aprobado',
        'codigo',
        'descripcion',
        'version',
        'fecha_aprobado',
        'objetivo',
        'alcance',
        'diagrama',
        'deleted_at'
    ];


    public function tipo_proceso(){
        return $this->belongsTo(SGCTipoProceso::class, 'idtipo_proceso');
    }
    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
