<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('chaves', function (Blueprint $table) {
            $table->id();
            $table->string('nomePessoa');
            $table->string('nomeChave');
            $table->date('horaEntrada');
            $table->date('horaSaida');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chaves');
    }
};
