<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            [
                'nombre' => 'Habitación Estándar',
                'descripcion' => 'Una habitación cómoda y acogedora con todas las comodidades básicas.',
                'precio' => 100.00,
                'imagen' => 'habitacion_estandar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Habitación Doble',
                'descripcion' => 'Una habitación espaciosa con dos camas dobles, ideal para familias o grupos.',
                'precio' => 150.00,
                'imagen' => 'habitacion_doble.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Suite de Lujo',
                'descripcion' => 'Una suite de lujo con una sala de estar separada y vistas panorámicas.',
                'precio' => 250.00,
                'imagen' => 'suite_lujo.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Habitación con Vistas al Mar',
                'descripcion' => 'Disfrute de impresionantes vistas al mar desde la comodidad de su habitación.',
                'precio' => 180.00,
                'imagen' => 'habitacion_vistas_mar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Habitación Familiar',
                'descripcion' => 'Una habitación grande con varias camas y mucho espacio para toda la familia.',
                'precio' => 200.00,
                'imagen' => 'habitacion_familiar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Penthouse',
                'descripcion' => 'El máximo lujo, con su propia terraza privada y jacuzzi.',
                'precio' => 500.00,
                'imagen' => 'penthouse.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
