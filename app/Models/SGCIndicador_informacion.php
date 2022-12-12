<?php

namespace App\Models;

use App\Models\SGCIndicador as ModelsSGCIndicador;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCIndicador_informacion extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.indicador_informacion";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idtipo_accion',
        'idindicador',
        'iddocumento',
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

    public function indicador(){
        return $this->belongsTo(SGCIndicador::class, 'idindicador');
    }

    public function documento(){
        return $this->belongsTo(SGCDocumento::class, 'iddocumento');
    }


    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
