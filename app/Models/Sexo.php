<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Sexo extends Model
{
    use SoftDeletes;

    protected $table        = "general.sexo";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'simbolo',
        'deleted_at'
    ];
}
