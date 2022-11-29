<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Facultad extends Model
{
    use SoftDeletes;

    protected $table        = "facultad.facultad";
    protected $primaryKey   = "id";

    protected $fillable = [
        'facultad',
        'abreviatura',
        'deleted_at'  
    ];
}
