<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SGCProceso_cero extends Model
{
    use SoftDeletes;

    protected $table        = "sgc.entidad";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'deleted_at'
    ];


    public function comision(){
        return $this->belongsTo(SGCTipoProceso::class, 'idtipo_proceso');
    }

    public function mov_comision(){
        return $this->belongsTo(SGCTipoProceso::class, 'idtipo_proceso');
    }

    public function consejo(){
        return $this->belongsTo(SGCTipoProceso::class, 'idtipo_proceso');
    }

    public function mov_consejo(){
        return $this->belongsTo(SGCTipoProceso::class, 'idtipo_proceso');
    }

    
    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }
}
