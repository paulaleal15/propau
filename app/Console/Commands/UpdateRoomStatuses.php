<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Habitacion;
use Carbon\Carbon;

class UpdateRoomStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rooms:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update room statuses based on active and upcoming reservations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating room statuses...');
        $now = Carbon::now();

        // Obtener todas las habitaciones que no están en mantenimiento
        $habitaciones = Habitacion::where('estado', '!=', 'mantenimiento')->get();

        foreach ($habitaciones as $habitacion) {
            // Comprobar si hay una reserva activa en este momento
            $isCurrentlyOccupied = $habitacion->reservas()
                ->where('fecha_inicio', '<=', $now)
                ->where('fecha_fin', '>', $now)
                ->exists();

            if ($isCurrentlyOccupied) {
                if ($habitacion->estado !== 'ocupada') {
                    $habitacion->update(['estado' => 'ocupada']);
                    $this->info("Room #{$habitacion->numero} is now occupied.");
                }
            } else {
                // Si no hay reserva activa, la habitación debería estar disponible
                if ($habitacion->estado !== 'disponible') {
                    $habitacion->update(['estado' => 'disponible']);
                    $this->info("Room #{$habitacion->numero} is now available.");
                }
            }
        }

        $this->info('Done.');
        return 0;
    }
}
