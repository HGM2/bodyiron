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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('nombre'); // Nombre del cliente
            $table->string('apellido_paterno'); // Apellido paterno
            $table->string('apellido_materno'); // Apellido materno
            $table->string('email')->unique(); // Email único
            $table->string('password'); // Contraseña
            $table->string('username')->unique(); // Nombre de usuario único
            $table->string('direccion')->nullable(); // Dirección opcional
            $table->string('telefono')->nullable(); // Teléfono opcional
            $table->timestamp('fecha_registro')->useCurrent(); // Fecha de registro
            $table->foreignId('tipo_membresia')->constrained('membresias'); // Tipo de membresía
            $table->string('foto')->nullable(); // Ruta de la foto del cliente
            $table->string('qr_codigo')->nullable(); // Ruta del QR
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
