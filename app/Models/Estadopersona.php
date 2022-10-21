<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Estadopersona extends Model
{
    use SoftDeletes;

    protected $table        = "general.estadopersona";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'deleted_at'
    ];
}
