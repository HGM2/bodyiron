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
        Schema::create('acceso', function (Blueprint $table) {
            $table->id(); // ID único
            $table->foreignId('usuario_id')->constrained('usuarios'); // Usuario asociado
            $table->timestamp('fecha_hora_entrada')->nullable(); // Fecha y hora de entrada
            $table->timestamp('fecha_hora_salida')->nullable(); // Fecha y hora de salida
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acceso');
    }
};
