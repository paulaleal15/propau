<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habitaciones = Habitacion::with('producto')->get();
        return view('admin.habitaciones.index', compact('habitaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('admin.habitaciones.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'numero' => 'required|string|max:255',
            'piso' => 'required|string|max:255',
            'estado' => 'required|string|in:disponible,ocupada,mantenimiento',
        ]);

        Habitacion::create($request->all());

        return redirect()->route('habitaciones.index')->with('success', 'Habitación creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Habitacion $habitacion)
    {
        return view('admin.habitaciones.show', compact('habitacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habitacion $habitacion)
    {
        $productos = Producto::all();
        return view('admin.habitaciones.edit', compact('habitacion', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'numero' => 'required|string|max:255',
            'piso' => 'required|string|max:255',
            'estado' => 'required|string|in:disponible,ocupada,mantenimiento',
        ]);

        $habitacion->update($request->all());

        return redirect()->route('habitaciones.index')->with('success', 'Habitación actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitacion $habitacion)
    {
        $habitacion->delete();

        return redirect()->route('habitaciones.index')->with('success', 'Habitación eliminada con éxito.');
    }

    public function booking(Habitacion $habitacion)
    {
        return view('admin.habitaciones.booking', compact('habitacion'));
    }

    public function storeBooking(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        $conflictingReservations = PedidoDetalle::where('habitacion_id', $habitacion->id)
            ->where('fecha_inicio', '<', $request->fecha_fin)
            ->where('fecha_fin', '>', $request->fecha_inicio)
            ->exists();

        if ($conflictingReservations) {
            return redirect()->back()->withErrors(['error' => 'La habitación no está disponible en las fechas seleccionadas.']);
        }

        $pedido = Pedido::create([
            'user_id' => auth()->id(),
            'total' => $habitacion->producto->precio,
            'estado' => 'pendiente',
        ]);

        $pedido->detalles()->create([
            'habitacion_id' => $habitacion->id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'precio' => $habitacion->producto->precio,
            'cantidad' => 1,
        ]);

        return redirect()->route('habitaciones.index')->with('success', 'Reserva creada con éxito.');
    }
}
