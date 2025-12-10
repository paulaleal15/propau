<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'numero',
        'piso',
        'estado',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Define la relación con las reservas (detalles de pedido).
     */
    public function reservas()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
}
