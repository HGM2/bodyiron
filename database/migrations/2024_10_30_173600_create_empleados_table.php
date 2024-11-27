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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('nombre'); // Nombre del empleado
            $table->string('apellido_paterno'); // Apellido paterno
            $table->string('apellido_materno'); // Apellido materno
            $table->string('email')->unique(); // Email único
            $table->string('puesto'); // Puesto del empleado (nutricionista o entrenador)
            $table->decimal('salario_hora', 8, 2); // Salario por hora
            $table->timestamp('fecha_contratacion')->useCurrent(); // Fecha de contratación
            $table->text('experiencia')->nullable(); // Experiencia del empleado
            $table->string('foto')->nullable(); // Ruta de la foto del empleado
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
