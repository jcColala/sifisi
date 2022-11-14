<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCProceso_cero extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.proceso_cero";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idtipo_proceso',
        'descripcion',
        'abrev',
        'version',
        'responsable',
        'objetivo',
        'alcance',
        'objetivo',
        'alcance',
        'proveedores',
        'entradas',
        'salidas',
        'clientes',
        'nombre_elaborado',
        'nombre_revisado',
        'nombre_aprobado',
        'cargo_elaborado',
        'cargo_revisado',
        'cargo_aprobado',
        'deleted_at'
    ];


    public function tipo_proceso(){
        return $this->belongsTo(SGCTipoProceso::class, 'idtipo_proceso');
    }
    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
