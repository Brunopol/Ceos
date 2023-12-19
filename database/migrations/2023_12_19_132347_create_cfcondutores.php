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
        Schema::create('cfcondutores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome')->nullable();
            $table->string('cpf');
            $table->string('setor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cfcondutores');
    }
};
