<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCIndicador extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.indicador";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idresponsable',
        'idelaborado',
        'idrevisado',
        'idaprobado',
        'idtipo_accion',
        'idproceso_uno',
        'idperiodicidad',
        'codigo',
        'descripcion',
        'version',
        'version_ficha',
        'objetivo',
        'fecha_aprobacion',
        'varialbes',
        'calculo',
        'informacion',
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
