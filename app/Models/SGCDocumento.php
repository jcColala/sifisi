<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCDocumento extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.documentos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idtipo_accion',
        'idtipo_documento',
        'identidad',
        'idresolucion',
        'idtipo_archivo',
        'codigo',
        'descripcion',
        'fecha_emision',
        'fecha_aprobacion',
        'ubicacion_fisica',
        'version',
        'documento',
        'porcentaje',
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


    public function resolucion(){
        return $this->belongsTo(SGCTipo_accion::class, 'idresolucion');
    }
    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
