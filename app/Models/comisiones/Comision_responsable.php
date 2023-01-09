<?php

namespace App\Models\comisiones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Persona;

class Comision_responsable extends Model
{
    use SoftDeletes;

    protected $table        = "comisiones.comision_responsable";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idcomision',
        'idresponsable',
        'presidente',
        'deleted_at'  
    ];

    public function persona(){
        return $this->belongsTo(Persona::class,'idresponsable');
    }
}
