<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    protected $table = 'habitaciones';

    protected $fillable = [
        'producto_id',
        'numero',
        'piso',
        'estado', // disponible, ocupada, mantenimiento
    ];

    /**
     * Get the product that owns the room.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
