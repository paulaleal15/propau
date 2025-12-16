<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PedidoController extends Controller
{
    public function index(Request $request){
        $texto = $request->input('texto');

        // Cambiamos la consulta base a PedidoDetalle para listar reservas individuales
        $query = PedidoDetalle::with('pedido.user', 'producto')->orderBy('fecha_inicio', 'desc');

        // Permisos
        if (auth()->user()->can('pedido-list')) {
            // El admin puede ver todas las reservas
        } elseif (auth()->user()->can('pedido-view')) {
            // El usuario solo puede ver sus propias reservas
            $query->whereHas('pedido', function ($q) {
                $q->where('user_id', auth()->id());
            });
        } else {
            abort(403, 'No tienes permisos para ver las reservas.');
        }

        // Búsqueda por nombre de usuario o nombre de habitación
        if (!empty($texto)) {
            $query->where(function($q) use ($texto) {
                $q->whereHas('pedido.user', function ($subq) use ($texto) {
                    $subq->where('name', 'like', "%{$texto}%");
                })->orWhereHas('producto', function ($subq) use ($texto) {
                    $subq->where('nombre', 'like', "%{$texto}%");
                });
            });
        }

        $registros = $query->paginate(10);

        return view('pedido.index', compact('registros', 'texto'));
    }

    public function mostrarPago()
    {
        $carrito = session('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'No hay nada que pagar. Tu carrito está vacío.');
        }
        return view('web.pago');
    }

    public function procesarPago(Request $request)
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('mensaje', 'El carrito está vacío.');
        }

        DB::beginTransaction();
        try {
            // 1. Calcular el total (de nuevo, por seguridad)
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            // 2. Crear el pedido
            $pedido = Pedido::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'estado' => 'pagado' // Cambiado de 'pendiente' a 'pagado'
            ]);

            // 3. Crear los detalles del pedido
            foreach ($carrito as $item) {
                PedidoDetalle::create([
                    'pedido_id'    => $pedido->id,
                    'producto_id'  => $item['id'],
                    'cantidad'     => $item['cantidad'],
                    'precio'       => $item['precio'],
                    'fecha_inicio' => $item['fecha_inicio'],
                    'fecha_fin'    => $item['fecha_fin'],
                    'huespedes'    => $item['huespedes'],
                ]);
            }

            // 4. Vaciar el carrito de la sesión
            session()->forget('carrito');

            DB::commit();

            // Redirigir a una página de éxito o al listado de pedidos del usuario
            return redirect()->route('perfil.pedidos')->with('mensaje', '¡Pago realizado y pedido completado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Error al procesar el pago: ' . $e->getMessage());
            return redirect()->route('pago.mostrar')->with('error', 'Hubo un error al procesar el pago. Por favor, inténtalo de nuevo.');
        }
    }

}