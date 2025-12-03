<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;

class HabitacionController extends Controller
{
    public function updateStatus(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'estado' => 'required|in:Disponible,Ocupada,Limpieza,Mantenimiento',
        ]);

        $habitacion->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado de la habitación actualizado con éxito.');
    }
}
