<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable implements JWTSubject
{
    protected $table = 'usuarios';
    
    use Notifiable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function datos()
    {
        return $this->hasOne(DatoUsuario::class, 'usuarios_id')->withDefault();
    }
    public function nombreCompleto()
    {
        return $this->datos->nombre . ' ' . $this->datos->apellidos;
    }
    public function rol()
    {
        return $this->hasOne(Rol::class, 'id', 'roles_id');
    }
    public function verificacion()
    {
        return $this->hasOne(UsuarioVerificacion::class, 'usuarios_id')->withDefault([
            'estados_verificaciones_id' => 1
        ]);
    }
    public function accesoSubasta()
    {
        return $this->hasOne(AccesoSubasta::class, 'id_usuarios', 'id')->withDefault();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
