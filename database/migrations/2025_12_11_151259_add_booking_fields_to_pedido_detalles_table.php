<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedido_detalles', function (Blueprint $table) {
            $table->foreignId('habitacion_id')->nullable()->constrained('habitaciones')->onDelete('set null');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedido_detalles', function (Blueprint $table) {
            $table->dropForeign(['habitacion_id']);
            $table->dropColumn(['habitacion_id', 'fecha_inicio', 'fecha_fin']);
        });
    }
};
