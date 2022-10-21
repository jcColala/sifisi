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
        'deleted_at'
    ];
}
