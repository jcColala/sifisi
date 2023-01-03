<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCFicha_indicador_uno extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.ficha_indicador_uno";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idtipo_accion',
        'idindicador_uno',
        'idresponsable',
        'codigo',
        'descripcion',
        'version',
        'fecha_aprobado',
        'objetivo',
        'descripcion_variables',
        'forma_calculo',
        'idperiodicidad',
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

    public function indicador_uno(){
        return $this->belongsTo(SGCIndicador_uno::class, 'idindicador_uno');
    }

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
