<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->json('ingredientes')->nullable();
            $table->decimal('precio', 10, 2);
            $table->string('imagen');
            $table->integer('stock')->default(0);
            $table->foreignId('subcategoria_id')->constrained('subcategorias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
}; 