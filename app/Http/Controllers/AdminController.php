<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;

class AdminController extends Controller
{
    public function gestionHabitaciones(Request $request)
    {
        $query = Habitacion::with('producto');

        // Búsqueda por número o tipo de habitación
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('numero', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('producto', function($q) use ($searchTerm) {
                      $q->where('nombre', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filtro por estado
        if ($request->has('estado') && $request->estado && $request->estado !== 'Todas') {
            $query->where('estado', $request->estado);
        }

        $habitaciones = $query->orderBy('numero')->get();

        // Obtener contadores para los filtros
        $counts = [
            'Todas' => Habitacion::count(),
            'Disponibles' => Habitacion::where('estado', 'Disponible')->count(),
            'Ocupadas' => Habitacion::where('estado', 'Ocupada')->count(),
        ];

        return view('admin.gestion-habitaciones', compact('habitaciones', 'counts'));
    }

    public function calendarioReservas()
    {
        return view('admin.calendario-reservas');
    }

    public function gestionReservas()
    {
        return view('admin.gestion-reservas');
    }

    public function inventarioTarifas()
    {
        return view('admin.inventario-tarifas');
    }

    public function reporteAnalisis()
    {
        return view('admin.reporte-analisis');
    }
}
