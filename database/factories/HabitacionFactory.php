<?php

namespace Database\Factories;

use App\Models\Habitacion;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Habitacion>
 */
class HabitacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'producto_id' => Producto::factory(),
            'numero' => $this->faker->unique()->numberBetween(100, 500),
            'piso' => $this->faker->numberBetween(1, 5),
            'estado' => $this->faker->randomElement(['disponible', 'ocupada', 'mantenimiento']),
        ];
    }
}
