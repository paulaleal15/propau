<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Habitacion;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HabitacionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function una_habitacion_pertenece_a_un_producto()
    {
        $producto = Producto::factory()->create();
        $habitacion = Habitacion::factory()->create(['producto_id' => $producto->id]);

        $this->assertInstanceOf(Producto::class, $habitacion->producto);
        $this->assertEquals($producto->id, $habitacion->producto->id);
    }
}
