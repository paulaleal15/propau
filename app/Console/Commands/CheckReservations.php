<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Habitacion;
use App\Models\PedidoDetalle;
use Carbon\Carbon;

class CheckReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired reservations and update room status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired reservations...');

        $expiredReservations = PedidoDetalle::where('fecha_fin', '<', Carbon::today())
            ->whereHas('habitacion', function ($query) {
                $query->where('estado', 'ocupada');
            })
            ->get();

        foreach ($expiredReservations as $reservation) {
            $habitacion = $reservation->habitacion;
            $habitacion->estado = 'disponible';
            $habitacion->save();
            $this->info("Room {$habitacion->numero} is now available.");
        }

        $this->info('Done.');
    }
}
