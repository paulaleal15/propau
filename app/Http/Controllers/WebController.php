<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Habitacion;

class WebController extends Controller
{
    public function index(Request $request){
        $query=Producto::query();
        // Búsqueda por nombre
        if ($request->has('search') && $request->search) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        // Filtro de orden (Ordenar por precio)
        if ($request->has('sort') && $request->sort) {
            switch ($request->sort) {
                case 'priceAsc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'priceDesc':
                    $query->orderBy('precio', 'desc');
                    break;
                default:
                    $query->orderBy('nombre', 'asc');
                    break;
            }
        }
        // Obtener productos filtrados
        $productos = $query->paginate(10);    
        return view('web.index', compact('productos'));

    }

    public function show($id){
        // Obtener el producto por ID
        $producto = Producto::findOrFail($id);        
        // Pasar el producto a la vista
        return view('web.item', compact('producto'));
    }

    public function habitaciones(Request $request){
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

        return view('web.habitaciones', compact('habitaciones', 'counts'));
    }
}
