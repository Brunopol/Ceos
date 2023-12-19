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
        Schema::create('cfcarros', function (Blueprint $table) {
            $table->id();
            $table->string('numero_veiculo');
            $table->string('placa');
            $table->string('modelo');
            $table->string('renavan');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cfcarros');
    }
};
