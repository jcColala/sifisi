<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Persona extends Model
{
    use SoftDeletes;

    protected $table        = "general.persona";
    protected $primaryKey   = "id";

    protected $fillable = [
        'id',
        'idescuela',
        'idestadopersona',
        'idtipopersona',
        'ubigeo_origen',
        'ubigeo_actual',
        'idtipo_documento_identidad',
        'numero_documento_identidad',
        'idestado_civil',
        'idsexo',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'correo_institucional',
        'correo_personal',
        'direccion',
        'telefono',
        'fecha_nacimiento',
        'nacionalidad',
        'deleted_at'
    ];

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
