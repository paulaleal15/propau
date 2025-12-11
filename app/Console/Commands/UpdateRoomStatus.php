<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Habitacion;
use App\Models\PedidoDetalle;
use Carbon\Carbon;

class UpdateRoomStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-room-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el estado de las habitaciones en función de las fechas de reserva';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Find rooms with expired bookings and set them to 'disponible'
        $expiredBookings = PedidoDetalle::where('fecha_fin', '<', $today)
            ->whereHas('habitacion', function ($query) {
                $query->where('estado', 'ocupada');
            })
            ->get();

        foreach ($expiredBookings as $booking) {
            $booking->habitacion->update(['estado' => 'disponible']);
        }

        // Find rooms with active bookings and set them to 'ocupada'
        $activeBookings = PedidoDetalle::where('fecha_inicio', '<=', $today)
            ->where('fecha_fin', '>=', $today)
            ->whereHas('habitacion', function ($query) {
                $query->where('estado', 'disponible');
            })
            ->get();

        foreach ($activeBookings as $booking) {
            $booking->habitacion->update(['estado' => 'ocupada']);
        }

        $this->info('Estados de las habitaciones actualizados con éxito.');
    }
}
