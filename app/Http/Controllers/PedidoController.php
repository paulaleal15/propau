<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    public function index(Request $request){
        $texto = $request->input('texto');
        $query = Pedido::with('user', 'detalles.producto')->orderBy('id', 'desc');

        // Permisos
        if (auth()->user()->can('pedido-list')) {
            // Puede ver todos los pedidos
        } elseif (auth()->user()->can('pedido-view')) {
            // Solo puede ver sus propios pedidos
            $query->where('user_id', auth()->id());
        } else {
            abort(403, 'No tienes permisos para ver pedidos.');
        }

        // Búsqueda por nombre del usuario
        if (!empty($texto)) {
            $query->whereHas('user', function ($q) use ($texto) {
                $q->where('name', 'like', "%{$texto}%");
            });
        }
        $registros = $query->paginate(10);
        return view('pedido.index', compact('registros', 'texto'));
    }

    public function realizar(Request $request)
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->back()->with('mensaje', 'El carrito está vacío.');
        }

        // Simplemente redirigir. El carrito ya está en la sesión principal.
        return redirect()->route('pago.mostrar');
    }

    public function mostrarPago()
    {
        $carrito = session('carrito', []);

        // Comprobar si el carrito (de la sesión principal) está vacío
        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'Tu carrito está vacío.');
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
            Log::error('Error al procesar el pago: ' . $e->getMessage());
            return redirect()->route('pago.mostrar')->with('error', 'Hubo un error al procesar el pago. Por favor, inténtalo de nuevo.');
        }
    }

    public function cambiarEstado(Request $request, $id){
        $pedido = Pedido::findOrFail($id);
        $estadoNuevo = $request->input('estado');

        // Validar que el estado nuevo sea uno permitido
        $estadosPermitidos = ['enviado', 'anulado', 'cancelado'];

        if (!in_array($estadoNuevo, $estadosPermitidos)) {
            abort(403, 'Estado no válido');
        }

        // Verificar permisos según el estado
        if (in_array($estadoNuevo, ['enviado', 'anulado'])) {
            if (!auth()->user()->can('pedido-anulate')) {
                abort(403, 'No tiene permiso para cambiar a "enviado" o "anulado"');
            }
        }

        if ($estadoNuevo === 'cancelado') {
            if (!auth()->user()->can('pedido-cancel')) {
                abort(403, 'No tiene permiso para cancelar pedidos');
            }
        }

        // Cambiar el estado
        $pedido->estado = $estadoNuevo;
        $pedido->save();

        return redirect()->back()->with('mensaje', 'El estado del pedido fue actualizado a "' . ucfirst($estadoNuevo) . '"');
    }
}