<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCProceso_uno extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.proceso_uno";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idproceso_cero',
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
