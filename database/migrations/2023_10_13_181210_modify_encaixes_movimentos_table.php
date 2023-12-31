<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('encaixe_movimentos', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->default(null);
                $table->foreign('user_id')->references('id')->on('users');
        });
    }


    public function down()
    {
        Schema::table('encaixe_movimentos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
