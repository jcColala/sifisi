<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MOVSGCMov_estado extends Model
{
    use SoftDeletes;

    protected $table        = "movsgc.mov_estado";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'deleted_at'
    ];

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
