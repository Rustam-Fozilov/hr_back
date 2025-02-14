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
        Schema::table('branches', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment("0-inactive, 1-active");
            $table->string('name');
            $table->string('address', 1024)->nullable();
            $table->string('location', 1024)->nullable();
            $table->string('token')->unique();
            $table->foreignId('region_id')->nullable()->references('id')->on('regions');
            $table->string('phones', 512)->nullable();
            $table->string('link')->nullable();
            $table->string('info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('name');
            $table->dropColumn('address');
            $table->dropColumn('location');
            $table->dropColumn('token');
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
            $table->dropColumn('phones');
            $table->dropColumn('link');
            $table->dropColumn('info');
        });
    }
};
