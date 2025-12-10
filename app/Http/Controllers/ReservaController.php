<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Muestra la página para seleccionar las fechas de reserva para una habitación específica.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function seleccionarFechas($id)
    {
        $habitacion = Habitacion::with('producto')->findOrFail($id);
        return view('web.reservas.fechas', compact('habitacion'));
    }

    /**
     * Verifica la disponibilidad de la habitación y la agrega al carrito si está disponible.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verificarDisponibilidad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'habitacion_id' => 'required|exists:habitaciones,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ], [
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);
        $habitacionId = $request->habitacion_id;

        // Lógica de conflicto: (StartA < EndB) Y (EndA > StartB)
        $conflicto = PedidoDetalle::where('habitacion_id', $habitacionId)
            ->where('fecha_inicio', '<', $fechaFin)
            ->where('fecha_fin', '>', $fechaInicio)
            ->exists();

        if ($conflicto) {
            return redirect()->back()
                ->with('error', 'La habitación no está disponible para las fechas seleccionadas. Por favor, elija otras fechas.')
                ->withInput();
        }

        // La habitación está disponible, la añadimos al carrito.
        $carrito = session()->get('carrito', []);
        $habitacion = Habitacion::with('producto')->find($habitacionId);

        // ID único para el item del carrito para permitir reservar la misma habitación en diferentes fechas en el mismo carrito
        $item_id = 'habitacion_' . $habitacionId . '_' . $fechaInicio->timestamp;

        $noches = $fechaInicio->diffInDays($fechaFin);
        if ($noches == 0) $noches = 1; // Asegurar un mínimo de una noche
        $precioTotal = $noches * $habitacion->producto->precio;

        $carrito[$item_id] = [
            "tipo" => "habitacion",
            "habitacion_id" => $habitacion->id,
            "producto_id" => $habitacion->producto->id,
            "nombre" => $habitacion->producto->nombre,
            "cantidad" => 1,
            "precio" => $habitacion->producto->precio,
            "precio_total" => $precioTotal,
            "imagen" => $habitacion->producto->imagen,
            "fecha_inicio" => $fechaInicio->toDateString(),
            "fecha_fin" => $fechaFin->toDateString(),
            "noches" => $noches,
        ];

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.mostrar')->with('success', '¡Habitación disponible! La reserva ha sido añadida a tu carrito.');
    }
}
