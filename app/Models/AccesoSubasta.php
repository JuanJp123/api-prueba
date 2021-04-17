<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccesoSubasta extends Model
{
    protected $table = 'accesos_subastas';
    protected $guarded =[];
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    
}
