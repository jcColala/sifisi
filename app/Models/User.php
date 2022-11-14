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
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    //use HasApiTokens, HasFactory, Notifiable;


    protected $table        = "seguridad.usuario";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idpersona','usuario', 'password', 'avatar', 'es_superusuario', 'tema', 'deleted_at'
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
