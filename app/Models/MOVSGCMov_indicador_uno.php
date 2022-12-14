<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MOVSGCMov_indicador_uno extends Model
{
    use SoftDeletes;

    protected $table        = "movsgc.mov_indicador_uno";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idtipo_accion',
        'idproceso_uno',
        'idsgc',
        'version_proceso_uno',
        'codigo',
        'descripcion',
        'deleted_at'
    ];

    public function indicadores_uno(){
        return $this->hasMany(SGCFicha_indicador_uno::class, 'idindicador_uno');
    }

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

    public function proceso_uno(){
        return $this->belongsTo(SGCProceso_uno::class, 'idproceso_uno');
    }

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
