<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Funcion extends Model
{
    use SoftDeletes;

    protected $table        = "seguridad.funcion";
    protected $primaryKey   = "id";

    protected $fillable = [
        'nombre',
        'funcion',
        'clase',
        'icono',
        'orden',
        'mostrar',
        'boton',
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
