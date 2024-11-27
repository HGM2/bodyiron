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
        Schema::create('clases', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('nombre'); // Nombre de la clase
            $table->timestamp('fecha_hora'); // Fecha y hora de la clase
            $table->foreignId('empleado_id')->constrained('empleados'); // Entrenador responsable de la clase
            $table->integer('num_max_participantes')->unsigned(); // Número máximo de participantes
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
