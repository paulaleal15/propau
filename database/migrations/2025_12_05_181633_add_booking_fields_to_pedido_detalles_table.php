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
            $table->foreignId('habitacion_id')->nullable()->constrained('habitaciones')->onDelete('cascade');
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->foreignId('producto_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedido_detalles', function (Blueprint $table) {
            $table->dropForeign(['habitacion_id']);
            $table->dropColumn('habitacion_id');
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('fecha_fin');
            $table->foreignId('producto_id')->nullable(false)->change();
        });
    }
};
