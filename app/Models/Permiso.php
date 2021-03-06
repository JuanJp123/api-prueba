<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'roles_permisos', 'permisos_id', 'roles_id');
    }
}
