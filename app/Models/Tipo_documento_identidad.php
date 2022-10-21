<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tipo_documento_identidad extends Model
{
    use SoftDeletes;

    protected $table        = "general.tipo_documento_identidad";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'abreviatura',
        'deleted_at'
    ];
}
