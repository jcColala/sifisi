<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Modulo_padre extends Model
{
    use SoftDeletes;

    protected $table        = "seguridad.modulo_padre";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'abreviatura',
        'url',
        'icon',
        'orden',
        'deleted_at'
    ];
}
