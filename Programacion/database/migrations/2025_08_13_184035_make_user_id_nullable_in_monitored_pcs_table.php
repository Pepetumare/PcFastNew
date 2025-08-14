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
        Schema::table('monitored_pcs', function (Blueprint $table) {
            // Permitimos que la columna user_id sea nula (opcional)
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitored_pcs', function (Blueprint $table) {
            // Revertimos el cambio si es necesario
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};