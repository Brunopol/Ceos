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
        Schema::create('controleDeAcessos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('rgCpf');
            $table->string('transportadora')->nullable();
            $table->string('placa')->nullable();
            $table->string('horaEntrada');
            $table->string('horaSaida')->nullable();
            $table->string('setorResponsavelPessoa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('controleDeAcessos');
    }
};
