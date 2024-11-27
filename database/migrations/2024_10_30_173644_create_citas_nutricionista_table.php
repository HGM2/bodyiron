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
        Schema::create('citas_nutricionista', function (Blueprint $table) {
            $table->id(); // ID único
            $table->foreignId('cliente_id')->constrained('clientes'); // Cliente asociado a la cita
            $table->foreignId('nutricionista_id')->constrained('empleados'); // Nutricionista que atenderá la cita
            $table->timestamp('fecha_hora'); // Fecha y hora de la cita
            $table->text('descripcion')->nullable(); // Descripción de la cita
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas_nutricionista');
    }
};
