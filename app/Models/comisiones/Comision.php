<?php

namespace App\Models\comisiones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Comision extends Model
{
    use SoftDeletes;

    protected $table        = "comisiones.comision";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idcreador',
        'descripcion',
        'abreviatura',
        'resolucion',
        'especiales',
        'fecha_inicio',
        'fecha_fin',
        'anio',
        'mes',
        'editable',
        'deleted_at'
    ];
    
    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
