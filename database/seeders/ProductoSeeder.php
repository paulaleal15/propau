<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::firstOrCreate(
            ['codigo' => 'HI-001'],
            [
                'nombre' => 'Habitación Individual',
                'precio' => 50.00,
                'descripcion' => 'Perfecta para viajeros solitarios, equipada con todas las comodidades modernas.',
                'imagen' => 'habitacion-individual.jpg',
                'max_huespedes' => 1,
            ]
        );

        Producto::firstOrCreate(
            ['codigo' => 'HD-001'],
            [
                'nombre' => 'Habitación Doble',
                'precio' => 75.00,
                'descripcion' => 'Ideal para parejas, con una cama matrimonial o dos camas individuales.',
                'imagen' => 'habitacion-doble.jpg',
                'max_huespedes' => 2,
            ]
        );

        Producto::firstOrCreate(
            ['codigo' => 'HT-001'],
            [
                'nombre' => 'Habitación Triple',
                'precio' => 95.00,
                'descripcion' => 'Espacio y confort para pequeños grupos o familias.',
                'imagen' => 'habitacion-triple.jpg',
                'max_huespedes' => 3,
            ]
        );

        Producto::firstOrCreate(
            ['codigo' => 'SJ-001'],
            [
                'nombre' => 'Suite Junior',
                'precio' => 120.00,
                'descripcion' => 'Un espacio de lujo con sala de estar separada y vistas panorámicas.',
                'imagen' => 'suite-junior.jpg',
                'max_huespedes' => 2,
            ]
        );

        Producto::firstOrCreate(
            ['codigo' => 'SP-001'],
            [
                'nombre' => 'Suite Presidencial',
                'precio' => 250.00,
                'descripcion' => 'La máxima expresión de lujo y exclusividad, con servicios premium.',
                'imagen' => 'suite-presidencial.jpg',
                'max_huespedes' => 4,
            ]
        );

        Producto::firstOrCreate(
            ['codigo' => 'HF-001'],
            [
                'nombre' => 'Habitación Familiar',
                'precio' => 150.00,
                'descripcion' => 'Amplia y cómoda, diseñada para que toda la familia disfrute de su estancia.',
                'imagen' => 'habitacion-familiar.jpg',
                'max_huespedes' => 5,
            ]
        );
    }
}
