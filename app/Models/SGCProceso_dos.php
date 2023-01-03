<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCProceso_dos extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.proceso_dos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idtipo_accion',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idproceso_uno',
        'idresponsable',
        'version',
        'fecha_aprobado',
        'codigo',
        'descripcion',
        'objetivo',
        'alcance',
        'proveedores',
        'entradas',
        'salidas',
        'clientes',
        'diagrama',
        'editable',
        'deleted_at'
    ];

    public function proceso_uno(){
        return $this->belongsTo(SGCProceso_uno::class, 'idproceso_uno');
    }

    public function indicadores(){
        return $this->hasMany(SGCIndicador_dos::class, 'idproceso_dos');
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
