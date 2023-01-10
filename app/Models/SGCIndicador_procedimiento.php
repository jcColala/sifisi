<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCIndicador_procedimiento extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.indicador_procedimiento";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idtipo_accion',
        'idprocedimiento',
        'codigo',
        'descripcion',
        'deleted_at'
    ];

    public function fichas_indicador_procedimiento(){
        return $this->hasMany(SGCFicha_indicador_procedimiento::class, 'idindicador_procedimiento');
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

    public function procedimiento(){
        return $this->belongsTo(SGCProceso_dos::class, 'idprocedimiento');
    }

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
