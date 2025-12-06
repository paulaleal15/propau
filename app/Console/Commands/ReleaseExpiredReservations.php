<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PedidoDetalle;
use App\Models\Habitacion;
use Carbon\Carbon;

class ReleaseExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release expired reservations and set room status to available';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredReservations = PedidoDetalle::where('fecha_fin', '<', Carbon::now())
            ->whereNotNull('habitacion_id')
            ->get();

        foreach ($expiredReservations as $reservation) {
            $reservation->habitacion->update(['estado' => 'disponible']);
        }

        $this->info('Expired reservations released successfully.');
    }
}
