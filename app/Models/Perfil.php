<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Perfil extends Model
{
    use SoftDeletes;

    protected $table        = "seguridad.perfil";
    protected $primaryKey   = "id";

    protected $fillable = [
        'perfil',
        'abreviatura',
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
