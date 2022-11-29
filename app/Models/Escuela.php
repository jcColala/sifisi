<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Escuela extends Model
{
    use SoftDeletes;

    protected $table        = "facultad.escuela";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idfacultad',
        'escuela',
        'abreviatura',
        'deleted_at'  
    ];
}
