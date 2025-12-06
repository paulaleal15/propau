<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Habitacion;
use App\Models\PedidoDetalle;

class CarritoController extends Controller
{
    public function agregar(Request $request){
        $producto = Producto::findOrFail($request->producto_id);
        $cantidad = $request->cantidad ?? 1;

        $carrito = session()->get('carrito', []);
        if (isset($carrito[$producto->id])) {
            // Ya existe en el carrito, solo aumenta la cantidad
            $carrito[$producto->id]['cantidad'] += $cantidad;
        } else {
            // No existe, lo agregamos
            $carrito[$producto->id] = [
                'codigo' => $producto->codigo,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'imagen' => $producto->imagen,
                'cantidad' => $cantidad,
            ];
        }
        session()->put('carrito', $carrito);
        return redirect()->back()->with('mensaje', 'Producto agregado al carrito');
    }

    public function agregarHabitacion(Request $request)
    {
        $habitacion = Habitacion::with('producto')->findOrFail($request->habitacion_id);

        // Check for booking conflicts
        $isBooked = PedidoDetalle::whereHas('pedido', function ($query) {
            $query->where('estado', '!=', 'anulado');
        })
        ->where('habitacion_id', $habitacion->id)
            ->where(function ($query) use ($request) {
                $query->where('fecha_inicio', '<', $request->fecha_fin)
                      ->where('fecha_fin', '>', $request->fecha_inicio);
            })->exists();

        if ($isBooked) {
            return redirect()->back()->with('error', 'La habitación ya está reservada para las fechas seleccionadas.');
        }

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$habitacion->id])) {
            return redirect()->back()->with('mensaje', 'La habitación ya está en el carrito.');
        }

        $carrito[$habitacion->id] = [
            'habitacion_id' => $habitacion->id,
            'producto_id' => $habitacion->producto->id,
            'nombre' => $habitacion->producto->nombre,
            'numero' => $habitacion->numero,
            'precio' => $habitacion->producto->precio,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'cantidad' => 1,
        ];

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.mostrar')->with('mensaje', 'Habitación agregada al carrito.');
    }

    public function mostrar(){
        $carrito =session('carrito', []);
        return view('web.pedido', compact('carrito'));
    }

    public function sumar(Request $request){
        $productoId = $request->producto_id;

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$productoId])) {
            $carrito[$productoId]['cantidad'] += 1;
            session()->put('carrito', $carrito);
        }

        return redirect()->back()->with('mensaje', 'Cantidad actualizada en el carrito');
    }

    public function restar(Request $request){
        $productoId = $request->producto_id;

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$productoId])) {
            if ($carrito[$productoId]['cantidad'] > 1) {
                // Resta 1 si la cantidad es mayor a 1
                $carrito[$productoId]['cantidad'] -= 1;
            } 
            else{
                // Si es 1, lo quitamos del carrito
                unset($carrito[$productoId]);
            }
            session()->put('carrito', $carrito);
        }

        return redirect()->back()->with('mensaje', 'Cantidad actualizada en el carrito');
    }
    public function eliminar($id){
        $carrito = session()->get('carrito');
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }
        return redirect()->back()->with('success', 'Producto eliminado');
    }
    public function vaciar(){
        session()->forget('carrito');
        return redirect()->back()->with('success', 'Carrito vaciado');
    }
}
