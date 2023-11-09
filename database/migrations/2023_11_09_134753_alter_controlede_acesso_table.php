<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        
        Schema::table('controle_de_acessos', function (Blueprint $table) {
            $table->string('setorResponsavel')->nullable(); // Add a new column with the new name
        });

        DB::table('controle_de_acessos')
            ->update(['setorResponsavel' => DB::raw('setorResponsavelPessoa')]);

        Schema::table('controle_de_acessos', function (Blueprint $table) {
            $table->dropColumn('setorResponsavelPessoa'); // Drop the old column
        });
    }

    public function down()
    {
        Schema::table('controle_de_acessos', function (Blueprint $table) {
            $table->dropColumn('pessoaResponsavel'); // Rollback the migration (if needed)
        });

    }
};
