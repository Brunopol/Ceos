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
        Schema::create('cf', function (Blueprint $table) {
            $table->id();
            $table->string('destino');
            $table->string('data_saida');
            $table->string('hora_saida');
            $table->string('data_chegada');
            $table->string('hora_chegada');
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('id_condutor')->nullable()->default(null);
            $table->foreign('id_condutor')->references('id')->on('cfcondutores');
            $table->unsignedBigInteger('id_carro')->nullable()->default(null);
            $table->foreign('id_carro')->references('id')->on('cfcarros');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cf');
    }
};
