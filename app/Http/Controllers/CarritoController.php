<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function agregar(Request $request){
        // Validar que el producto_id está presente
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        $cantidad = $request->cantidad ?? 1;
        $carrito = session()->get('carrito', []);

        // Usar el ID del producto como clave para los artículos de tipo producto
        $item_id = $producto->id;

        if (isset($carrito[$item_id]) && $carrito[$item_id]['tipo'] == 'producto') {
            // Ya existe en el carrito, solo aumenta la cantidad
            $carrito[$item_id]['cantidad'] += $cantidad;
        } else {
            // No existe, lo agregamos
            $carrito[$item_id] = [
                'tipo' => 'producto', // Añadimos el tipo para diferenciarlo de las habitaciones
                'producto_id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'imagen' => $producto->imagen,
                'cantidad' => $cantidad,
            ];
        }
        session()->put('carrito', $carrito);
        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function mostrar(){
        $carrito = session('carrito', []);
        return view('web.pedido', compact('carrito'));
    }

    public function sumar(Request $request){
        $productoId = $request->producto_id;
        $carrito = session()->get('carrito', []);

        // Asegurarse de que el item existe y es de tipo 'producto'
        if (isset($carrito[$productoId]) && $carrito[$productoId]['tipo'] == 'producto') {
            $carrito[$productoId]['cantidad'] += 1;
            session()->put('carrito', $carrito);
        }

        return redirect()->back()->with('mensaje', 'Cantidad actualizada en el carrito');
    }

    public function restar(Request $request){
        $productoId = $request->producto_id;
        $carrito = session()->get('carrito', []);

        // Asegurarse de que el item existe y es de tipo 'producto'
        if (isset($carrito[$productoId]) && $carrito[$productoId]['tipo'] == 'producto') {
            if ($carrito[$productoId]['cantidad'] > 1) {
                // Resta 1 si la cantidad es mayor a 1
                $carrito[$productoId]['cantidad'] -= 1;
            } else {
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
