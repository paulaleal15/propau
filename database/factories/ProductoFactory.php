<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->ean8(),
            'nombre' => $this->faker->words(3, true),
            'precio' => $this->faker->randomFloat(2, 50, 200),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
