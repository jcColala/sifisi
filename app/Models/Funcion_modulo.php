<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Funcion_modulo extends Model
{
    use SoftDeletes;

    protected $table        = "seguridad.funcion_modulo";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idmodulo',
        'idfuncion',
        'deleted_at'  
    ];

    public function funcion(){
        return $this->belongsTo(Funcion::class,'idfuncion');
    }
}
