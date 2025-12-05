<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Producto;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Habitacion::with('producto');

        if ($request->has('estado') && $request->estado != '') {
            $query->where('estado', $request->estado);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('numero', 'like', '%' . $request->search . '%');
        }

        $habitaciones = $query->paginate(10);
        return view('admin.habitaciones.index', compact('habitaciones'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('admin.habitaciones.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'numero' => 'required|string|max:255|unique:habitaciones',
            'piso' => 'required|string|max:255',
            'estado' => 'required|in:disponible,ocupada,mantenimiento,limpieza',
        ]);

        Habitacion::create($request->all());

        return redirect()->route('admin.habitaciones.index')->with('success', 'Habitación creada exitosamente.');
    }

    public function edit(Habitacion $habitacion)
    {
        $productos = Producto::all();
        return view('admin.habitaciones.edit', compact('habitacion', 'productos'));
    }

    public function update(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'numero' => 'required|string|max:255|unique:habitaciones,numero,' . $habitacion->id,
            'piso' => 'required|string|max:255',
            'estado' => 'required|in:disponible,ocupada,mantenimiento,limpieza',
        ]);

        $habitacion->update($request->all());

        return redirect()->route('admin.habitaciones.index')->with('success', 'Habitación actualizada exitosamente.');
    }

    public function destroy(Habitacion $habitacion)
    {
        $habitacion->delete();
        return redirect()->route('admin.habitaciones.index')->with('success', 'Habitación eliminada exitosamente.');
    }
}
