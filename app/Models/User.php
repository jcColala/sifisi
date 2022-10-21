<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    //use HasApiTokens, HasFactory, Notifiable;


    protected $table        = "seguridad.usuario";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idpersona', 'id_encrypt','usuario', 'avatar', 'es_superusuario', 'password', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function persona(){
        return $this->belongsTo(Persona::class,'idpersona');
    }
    public function perfil(){
        return $this->belongsTo(Perfil::class,'idperfil');
    }
}
