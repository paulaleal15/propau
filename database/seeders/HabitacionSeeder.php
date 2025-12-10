<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitacion;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class HabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = Producto::all();

        foreach ($productos as $producto) {
            for ($i = 1; $i <= 2; $i++) {
                DB::table('habitaciones')->insert([
                    'producto_id' => $producto->id,
                    'numero' => $producto->id . '0' . $i,
                    'piso' => $producto->id,
                    'estado' => 'disponible',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
