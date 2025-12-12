<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function agregar(Request $request){
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'huespedes' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if ($request->huespedes > $producto->max_huespedes) {
            return back()->withErrors(['huespedes' => 'El número de huéspedes supera el máximo permitido para esta habitación.'])->withInput();
        }

        $fechaInicio = new \DateTime($request->fecha_inicio);
        $fechaFin = new \DateTime($request->fecha_fin);
        $diferencia = $fechaInicio->diff($fechaFin);
        $noches = $diferencia->days;

        if ($noches <= 0) {
            return back()->withErrors(['fecha_fin' => 'La fecha de salida debe ser posterior a la fecha de llegada.'])->withInput();
        }

        $carrito = session()->get('carrito', []);
        $carritoId = $producto->id . '-' . strtotime($request->fecha_inicio);

        if (isset($carrito[$carritoId])) {
             return redirect()->route('carrito.mostrar')->with('mensaje', 'Esta reserva ya se encuentra en tu carrito.');
        }

        $carrito[$carritoId] = [
            'id' => $producto->id,
            'codigo' => $producto->codigo,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'imagen' => $producto->imagen,
            'cantidad' => $noches,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'huespedes' => $request->huespedes,
        ];

        session()->put('carrito', $carrito);
        return redirect()->route('carrito.mostrar')->with('mensaje', 'Reserva añadida al carrito correctamente.');
    }

    public function mostrar(){
        $carrito =session('carrito', []);
        return view('web.pedido', compact('carrito'));
    }

    public function eliminar($carritoId){
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$carritoId])) {
            unset($carrito[$carritoId]);
            session()->put('carrito', $carrito);
        }
        return redirect()->back()->with('mensaje', 'Reserva eliminada del carrito.');
    }
    public function vaciar(){
        session()->forget('carrito');
        return redirect()->back()->with('success', 'Carrito vaciado');
    }
}
