<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MOVSGCMov_indicador extends Model
{
    use SoftDeletes;

    protected $table        = "movsgc.mov_indicador";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idestado',
        'idpersona_solicita',
        'idpersona_aprueba',
        'idproceso_uno',
        'codigo',
        'descripcion',
        'version',
        'objetivo',
        'varialbes',
        'calculo',
        'informacion',
        'periodicidad',
        'porcentaje',
        'deleted_at'
    ];


    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
