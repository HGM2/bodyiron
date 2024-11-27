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
        Schema::create('membresias', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('nombre'); // Nombre de la membresía
            $table->text('descripcion')->nullable(); // Descripción de la membresía
            $table->decimal('precio', 8, 2); // Precio de la membresía
            $table->integer('duracion')->unsigned(); // Duración en meses
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membresias');
    }
};
