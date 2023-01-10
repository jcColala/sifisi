<?php

namespace App\Models;

use App\Models\comisiones\Comision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCActividad_procedimiento extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.actividades_procedimiento";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idtipo_accion',
        'idprocedimiento',
        'idresponsable',
        'correlativo',
        'descripcion',
        'deleted_at'
    ];

    public function procedimiento(){
        return $this->belongsTo(SGCProcedimiento::class, 'idprocedimiento');
    }

    Public function comision(){
        return $this->hasOne(Comision::class, 'idresponsable');
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
