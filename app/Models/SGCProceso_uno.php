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
        'idtipo_accion',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idproceso_cero',
        'version',
        'fecha_aprobado',
        'codigo',
        'descripcion',
        'objetivo',
        'alcance',
        'diagrama',
        'editable',
        'deleted_at'
    ];
    public function procesos_dos(){
        return $this->hasMany(SGCProceso_dos::class, 'idproceso_uno');
    }

    public function indicadores(){
        return $this->hasMany(SGCIndicador_uno::class, 'idproceso_uno');
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
