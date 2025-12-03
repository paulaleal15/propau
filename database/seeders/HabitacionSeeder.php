<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Habitacion;

class HabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los tipos de habitación (Productos)
        $estandar = Producto::where('nombre', 'Estándar')->first();
        $deluxe = Producto::where('nombre', 'Deluxe')->first();
        $suite = Producto::where('nombre', 'Suite')->first();

        // Crear habitaciones de ejemplo
        if ($estandar) {
            Habitacion::create(['numero' => '101', 'piso' => '1', 'estado' => 'Disponible', 'producto_id' => $estandar->id]);
            Habitacion::create(['numero' => '102', 'piso' => '1', 'estado' => 'Ocupada', 'producto_id' => $estandar->id]);
        }

        if ($deluxe) {
            Habitacion::create(['numero' => '201', 'piso' => '2', 'estado' => 'Ocupada', 'producto_id' => $deluxe->id]);
            Habitacion::create(['numero' => '202', 'piso' => '2', 'estado' => 'Limpieza', 'producto_id' => $deluxe->id]);
        }

        if ($suite) {
            Habitacion::create(['numero' => '301', 'piso' => '3', 'estado' => 'Disponible', 'producto_id' => $suite->id]);
            Habitacion::create(['numero' => '302', 'piso' => '3', 'estado' => 'Mantenimiento', 'producto_id' => $suite->id]);
        }
    }
}
