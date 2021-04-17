<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoteInfo extends Model
{
    use HasFactory;
    protected $table = "lotes_info";
    protected $guarded = [];

    protected $fillable = [
        'productos_id',
        'cantidad',
        'lotes_procedencia_id',
        'observaciones',
        'video',
        'usuarios_id',
        'edad',
        'peso_promedio',
        'raza_o_cruce',
        'portada'
    ];
    public function estado()
    {
        return $this->hasOne(EstadoLoteOferta::class, 'id', 'estados_lotes_info')->withDefault();
    }

    public function loteOferta()
    {
        return $this->hasOne(LoteOferta::class, 'lotes_info_id', 'id')->where('estados_lotes_ofertas_id', 1)->withDefault([
            'tipo_oferta'              => 'Valor Kilo',
            'publicado_para_compartir' => 0
        ]);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id')->withDefault([
            'nombre' => 'Sin usuario',
            'email'  => 'Sin email'
        ]);
    }
}
