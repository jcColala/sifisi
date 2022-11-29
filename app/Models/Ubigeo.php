<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Ubigeo extends Model
{
    use SoftDeletes;

    protected $table        = "general.ubigeo";
    protected $primaryKey   = "id";

    protected $fillable = [
        'cod_dpto',
        'cod_prov',
        'cod_dist',
        'codccpp',
        'nombre',
        'reniec',
        'deleted_at'
    ];
}
