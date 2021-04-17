<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoteOferta extends Model
{
    use HasFactory;
    protected $table = "lotes_ofertas";
    protected $fillable = [
        'lotes_info_id',
        'tipos_ofertas_id',
        'valor',
        'tipo_oferta',
        'subastas_id',
    ];

  

    public function tipoOferta()
    {
        return $this->hasOne(TipoOferta::class, 'id', 'tipos_ofertas_id')->withDefault();
    }

    public function estado()
    {
        return $this->hasOne(EstadoLoteOferta::class, 'id', 'estados_lotes_ofertas_id')->withDefault();
    }

  

    public function lote()
    {
        return $this->belongsTo(LoteInfo::class, 'lotes_info_id', 'id');
    }
}
