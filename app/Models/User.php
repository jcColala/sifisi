<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;


    protected $table        = "seguridad.usuario";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idpersona','idperfil','usuario', 'password', 'avatar', 'es_superusuario', 'tema', 'deleted_at'
    ];

    const PATH_FILE         = 'images/users/';
    protected $appends      = ['path_file'];
    public function getPathFile(){
        return static::PATH_FILE;
    }

    public function getPathFileAttribute(){
        return url($this->getPathFile()).'/';
    }
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getTableName(){
        return (explode(".", $this->table))[1];
    }

    public function getSchemaName(){
        return (explode(".", $this->table))[0]??"public";
    }

    public function persona(){
        return $this->belongsTo(Persona::class,'idpersona');
    }
    public function perfil(){
        return $this->belongsTo(Perfil::class,'idperfil');
    }
}
