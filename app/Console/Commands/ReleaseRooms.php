<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PedidoDetalle;
use App\Models\Habitacion;
use Carbon\Carbon;

class ReleaseRooms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rooms:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release rooms whose reservation period has ended';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Releasing rooms...');

        $today = Carbon::today();

        $expiredReservations = PedidoDetalle::where('fecha_fin', '<', $today)->get();

        foreach ($expiredReservations as $reservation) {
            if ($reservation->habitacion) {
                $reservation->habitacion->update(['estado' => 'disponible']);
                $this->info("Room #{$reservation->habitacion->numero} released.");
            }
        }

        $this->info('Done.');
    }
}
