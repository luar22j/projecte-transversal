<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->text('consulta');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}; 