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
        Schema::table('metrics', function (Blueprint $table) {
            // Añadimos la columna para la llave foránea después de la columna 'id'
            // `constrained` se asegura de que el ID exista en la tabla 'monitored_pcs'
            // `onDelete('cascade')` borrará las métricas si el PC asociado es eliminado
            $table->foreignId('monitored_pc_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('metrics', function (Blueprint $table) {
            // Esto elimina la llave foránea y la columna si revertimos la migración
            $table->dropForeign(['monitored_pc_id']);
            $table->dropColumn('monitored_pc_id');
        });
    }
};