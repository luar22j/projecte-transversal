<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estados_pedido', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // Insertar estados iniciales
        DB::table('estados_pedido')->insert([
            ['nombre' => 'pendiente'],
            ['nombre' => 'en_proceso'],
            ['nombre' => 'enviado'],
            ['nombre' => 'entregado'],
            ['nombre' => 'cancelado']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_pedido');
    }
}; 