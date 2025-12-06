<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitacion;
use App\Models\Producto;

class HabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = Producto::all();

        if ($productos->isEmpty()) {
            $this->command->info('No hay productos en la base de datos, no se pueden crear habitaciones.');
            return;
        }

        foreach ($productos as $producto) {
            for ($i = 1; $i <= 5; $i++) {
                Habitacion::create([
                    'producto_id' => $producto->id,
                    'numero' => $producto->id . '0' . $i,
                    'piso' => $producto->id,
                    'estado' => 'disponible',
                ]);
            }
        }
    }
}
