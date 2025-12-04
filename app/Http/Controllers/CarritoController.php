<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Habitacion;
use Carbon\Carbon;

class CarritoController extends Controller
{
    public function create(Habitacion $habitacion)
    {
        return view('admin.crear-reserva', compact('habitacion'));
    }

    public function agregar(Request $request){
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'habitacion_id' => 'required|exists:habitaciones,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        $habitacion = Habitacion::with('producto')->findOrFail($request->habitacion_id);
        $producto = $habitacion->producto;

        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);
        $noches = $fechaFin->diffInDays($fechaInicio);

        $carrito = session()->get('carrito', []);

        // Usamos el ID de la habitación como clave para evitar duplicados
        $carritoKey = 'habitacion_' . $habitacion->id;

        if (isset($carrito[$carritoKey])) {
            // Si ya existe, se puede actualizar o mostrar un error. Por ahora, lo reemplazamos.
            $carrito[$carritoKey]['fecha_inicio'] = $fechaInicio->toDateString();
            $carrito[$carritoKey]['fecha_fin'] = $fechaFin->toDateString();
            $carrito[$carritoKey]['cantidad'] = $noches;
        } else {
            // No existe, lo agregamos
            $carrito[$carritoKey] = [
                'producto_id' => $producto->id,
                'habitacion_id' => $habitacion->id,
                'nombre' => $producto->nombre . ' - Hab. ' . $habitacion->numero,
                'precio' => $producto->precio,
                'cantidad' => $noches, // La cantidad es el número de noches
                'fecha_inicio' => $fechaInicio->toDateString(),
                'fecha_fin' => $fechaFin->toDateString(),
            ];
        }

        session()->put('carrito', $carrito);
        return redirect()->route('carrito.mostrar')->with('mensaje', 'Habitación agregada a la reserva.');
    }

    public function mostrar(){
        $carrito =session('carrito', []);
        return view('web.pedido', compact('carrito'));
    }

    public function sumar(Request $request){
        // Esta función podría no tener sentido en un contexto de reserva por fechas.
        // Se puede deshabilitar o adaptar si es necesario.
        return redirect()->back()->with('mensaje', 'No se puede cambiar la cantidad directamente.');
    }

    public function restar(Request $request){
        // Esta función podría no tener sentido en un contexto de reserva por fechas.
        // Se puede deshabilitar o adaptar si es necesario.
        return redirect()->back()->with('mensaje', 'No se puede cambiar la cantidad directamente.');
    }

    public function eliminar($id){
        $carrito = session()->get('carrito');
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }
        return redirect()->back()->with('success', 'Habitación eliminada de la reserva');
    }

    public function vaciar(){
        session()->forget('carrito');
        return redirect()->back()->with('success', 'Reserva vaciada');
    }
}
