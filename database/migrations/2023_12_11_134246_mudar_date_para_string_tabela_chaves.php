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
        Schema::table('chaves', function (Blueprint $table) {
            // First, drop the columns if they exist
            $table->dropColumn('horaEntrada');
            $table->dropColumn('horaSaida');
        
            // Then, add the columns back with the desired changes
            $table->string('novaHoraEntrada');  // Use a different name for the new column
            $table->string('novaHoraSaida')->nullable(); // Use a different name for the new column
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
