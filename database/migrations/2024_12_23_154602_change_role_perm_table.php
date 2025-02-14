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
        Schema::table('role_perms', function (Blueprint $table){
            $table->string('key')->change();
            $table->string('value')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_perms', function (Blueprint $table){
            $table->integer('key');
            $table->integer('value');
        });
    }
};
