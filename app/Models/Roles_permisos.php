<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles_permisos extends Model
{

    protected $table        = "seguridad.roles_permisos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
