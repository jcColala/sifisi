<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tipopersona extends Model
{
    use SoftDeletes;

    protected $table        = "general.tipopersona";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'deleted_at'
    ];
}
