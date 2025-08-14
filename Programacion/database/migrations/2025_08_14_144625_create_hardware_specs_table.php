<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void {
            Schema::create('hardware_specs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('monitored_pc_id')->constrained()->onDelete('cascade');
                $table->string('cpu');
                $table->integer('ram_total_gb');
                $table->json('disks'); // Guardaremos los detalles de los discos como JSON
                $table->string('motherboard');
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_specs');
    }
};
