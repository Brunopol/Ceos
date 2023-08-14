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
        Schema::create('encaixe_movimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encaixe_id')->constrained()->cascadeOnDelete();
            $table->string('nome');
            $table->string('largura');
            $table->string('tecido');
            $table->integer('quantidade');
            $table->string('parImper');
            $table->text('notas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentos');
    }
};
