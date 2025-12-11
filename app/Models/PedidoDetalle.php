<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'habitacion_id',
        'cantidad',
        'precio',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
    
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }
}
