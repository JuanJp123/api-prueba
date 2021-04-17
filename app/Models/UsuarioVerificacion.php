<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioVerificacion extends Model
{
    use HasFactory;
    protected $table   = 'usuarios_verificaciones';
    protected $guarded = [];
}
