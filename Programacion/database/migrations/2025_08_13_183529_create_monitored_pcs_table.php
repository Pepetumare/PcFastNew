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
        Schema::create('monitored_pcs', function (Blueprint $table) {
            $table->id();
            // Opcional: Para saber a qué usuario de tu sistema pertenece este PC.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Un nombre descriptivo, ej: "Notebook de Juan Pérez"
            $table->string('identifier')->unique(); // El identificador único que envía el agente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitored_pcs');
    }
};
