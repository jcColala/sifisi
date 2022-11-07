<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCTipo_proceso extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.tipo_proceso";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idpersona_solicita',
        'idpersona_aprueba',
        'idestado',
        'descripcion',
        'codigo',
        'deleted_at'
    ];

    public function procesos_cero(){
        return $this->hasMany(SGCProceso_cero::class);
    }

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
