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
        'idelaborado',
        'idrevisado',
        'idaprobado',
        'idtipo_accion',
        'editable',
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

    public function persona_solicita(){
        return $this->belongsTo(Persona::class, 'idpersona_solicita');
    }

    public function persona_aprueba(){
        return $this->belongsTo(Persona::class, 'idpersona_aprueba');
    }

    public function estado(){
        return $this->belongsTo(SGCEstado::class, 'idestado');
    }

    public function tipo_accion(){
        return $this->belongsTo(SGCTipo_accion::class, 'idtipo_accion');
    }

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
