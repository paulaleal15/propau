<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

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
        $clientes = User::all(); // Opcional: filtrar por rol de cliente si existe
        return view('admin.habitaciones.booking', compact('habitacion', 'clientes'));
    }

    public function storeBooking(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ], [
            'user_id.required' => 'Debe seleccionar un cliente.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.'
        ]);

        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);

        $conflictingReservations = PedidoDetalle::where('habitacion_id', $habitacion->id)
            ->where('fecha_inicio', '<', $fechaFin)
            ->where('fecha_fin', '>', $fechaInicio)
            ->exists();

        if ($conflictingReservations) {
            return redirect()->back()->withErrors(['error' => 'La habitación no está disponible en las fechas seleccionadas.'])->withInput();
        }

        // Calcular el número de noches. Si es el mismo día, cuenta como 1 noche.
        $noches = $fechaInicio->diffInDays($fechaFin);
        if ($fechaInicio->startOfDay()->equalTo($fechaFin->startOfDay())) {
            $noches = 1;
        }
        if ($noches == 0) $noches = 1; // Mínimo una noche

        $precioTotal = $noches * $habitacion->producto->precio;

        $pedido = Pedido::create([
            'user_id' => $request->user_id,
            'total' => $precioTotal,
            'estado' => 'pendiente',
        ]);

        $pedido->detalles()->create([
            'producto_id' => $habitacion->producto_id,
            'habitacion_id' => $habitacion->id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'precio' => $precioTotal, // Guardar el precio total del detalle
            'cantidad' => $noches, // Usar cantidad para almacenar el número de noches
        ]);

        return redirect()->route('habitaciones.index')->with('success', 'Reserva creada con éxito para el cliente seleccionado.');
    }
}
