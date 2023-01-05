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
        'idtipo_accion',
        'idsgc',
        'codigo',
        'descripcion',
        'objetivo',
        'alcance',
        'deleted_at'
    ];

    public function procesos_uno(){
        return $this->hasMany(SGCProceso_uno::class, 'idproceso_cero');
    }

    public function tipo_proceso(){
        return $this->belongsTo(SGCTipo_proceso::class, 'idtipo_proceso');
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

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
