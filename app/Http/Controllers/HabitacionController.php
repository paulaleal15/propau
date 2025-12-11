<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habitaciones = Habitacion::with('producto')->paginate(10);
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
            'estado' => 'required|in:disponible,ocupada,mantenimiento',
        ]);

        Habitacion::create($request->all());

        return redirect()->route('habitaciones.index')
            ->with('success', 'Habitación creada con éxito.');
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
            'estado' => 'required|in:disponible,ocupada,mantenimiento',
        ]);

        $habitacion->update($request->all());

        return redirect()->route('habitaciones.index')
            ->with('success', 'Habitación actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitacion $habitacion)
    {
        $habitacion->delete();

        return redirect()->route('habitaciones.index')
            ->with('success', 'Habitación eliminada con éxito.');
    }

    /**
     * Show the form for booking a room.
     */
    public function booking(Habitacion $habitacion)
    {
        return view('admin.habitaciones.booking', compact('habitacion'));
    }

    /**
     * Store a new booking.
     */
    public function storeBooking(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        if ($habitacion->estado !== 'disponible') {
            return back()->withErrors(['not_available' => 'La habitación no está disponible para reservar.']);
        }

        // Check for double booking
        $isBooked = PedidoDetalle::where('habitacion_id', $habitacion->id)
            ->where('fecha_inicio', '<', $request->fecha_fin)
            ->where('fecha_fin', '>', $request->fecha_inicio)
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['double_booking' => 'La habitación ya está reservada para las fechas seleccionadas.']);
        }

        // Calculate number of nights and total price
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);
        $noches = $fechaFin->diffInDays($fechaInicio);
        $total = $noches * $habitacion->producto->precio;

        // Create order
        $pedido = Pedido::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'estado' => 'completado',
        ]);

        // Create order detail
        PedidoDetalle::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $habitacion->producto->id,
            'habitacion_id' => $habitacion->id,
            'cantidad' => 1,
            'precio' => $habitacion->producto->precio,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        // If the booking starts today, update the room status immediately
        if ($fechaInicio->isToday()) {
            $habitacion->update(['estado' => 'ocupada']);
        }

        return redirect()->route('habitaciones.gallery')->with('success', 'Reserva realizada con éxito.');
    }

    /**
     * Display a gallery of rooms for booking.
     */
    public function gallery()
    {
        $habitaciones = Habitacion::with('producto')->paginate(6);
        return view('admin.habitaciones.gallery', compact('habitaciones'));
    }
}
