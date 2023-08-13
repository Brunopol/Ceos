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
        Schema::create('encaixes', function (Blueprint $table) {
            $table->id();
            $table->integer('corte_id_ref')->nullable();
            $table->string('nome_movimento')->nullable();
            $table->integer('tipo_reg')->nullable();
            $table->string('ref')->nullable();
            $table->string('largura')->nullable();
            $table->string('tecido')->nullable();
            $table->integer('qtd_pecas')->nullable();
            $table->string('parimpar')->nullable();
            $table->double('consumo')->nullable();
            $table->double('forro')->nullable();
            $table->double('consumo_tec1')->nullable();
            $table->double('consumo_tec2')->nullable();
            $table->double('consumo_tec3')->nullable();
            $table->text('notas')->nullable();
            $table->date('data_registro')->nullable();
            $table->integer('simulacao')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encaixes');
    }
};
