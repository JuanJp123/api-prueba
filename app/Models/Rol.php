<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table='roles';
    protected $guarded =[];
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'roles_permisos', 'roles_id', 'permisos_id');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'roles_id', 'id');
    }
}
