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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('nombre'); // Nombre del usuario
            $table->string('apellido_paterno'); // Apellido paterno
            $table->string('apellido_materno'); // Apellido materno
            $table->string('email')->unique(); // Email único
            $table->enum('tipo', ['admin', 'recepcionista', 'empleado', 'nutricionista', 'entrenador']); // Tipo de usuario
            $table->string('foto')->nullable(); // Ruta de la foto del usuario
            $table->string('password'); // Contraseña
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
