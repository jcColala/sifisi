<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Accesos extends Model
{
    use SoftDeletes;

    protected $table        = "seguridad.accesos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idmodulo',
        'idperfil',
        'acceder',
        'deleted_at'  
    ];
}
