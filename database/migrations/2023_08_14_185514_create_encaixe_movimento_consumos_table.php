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
        Schema::create('encaixe_movimento_consumos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('valor')->nullable();
            $table->foreignId('encaixe_movimento_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encaixe_movimento_consumos');
    }
};
