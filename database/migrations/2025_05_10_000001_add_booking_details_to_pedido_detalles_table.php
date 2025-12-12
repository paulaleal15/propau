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
            $table->date('fecha_inicio')->nullable()->after('producto_id');
            $table->date('fecha_fin')->nullable()->after('fecha_inicio');
            $table->integer('huespedes')->nullable()->after('fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedido_detalles', function (Blueprint $table) {
            $table->dropColumn(['fecha_inicio', 'fecha_fin', 'huespedes']);
        });
    }
};
