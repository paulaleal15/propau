<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PedidoDetalle extends Model
{
    protected $fillable = ['pedido_id', 'producto_id', 'cantidad', 'precio', 'fecha_inicio', 'fecha_fin', 'huespedes'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
    
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function getEstadiaStatusAttribute()
    {
        $hoy = Carbon::now();
        $inicio = Carbon::parse($this->fecha_inicio);
        $fin = Carbon::parse($this->fecha_fin);

        if ($this->pedido->estado === 'cancelado') {
            return 'Cancelada';
        }

        if ($hoy->lt($inicio)) {
            return 'Próxima';
        }

        if ($hoy->between($inicio, $fin)) {
            return 'En curso';
        }

        if ($hoy->gt($fin)) {
            return 'Finalizada';
        }

        return 'Desconocido';
    }
}
