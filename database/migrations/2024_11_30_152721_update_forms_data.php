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
        Schema::table('forms', function (Blueprint $table) {
            $table->dropForeign(['app_id']);
            $table->foreignId('app_id')->nullable()->change()->constrained('applications')->cascadeOnDelete();
        });

        Schema::table('form_degree_data', function (Blueprint $table) {
            $table->text('additional')->nullable()->change();
        });

        Schema::table('form_blitz_data', function (Blueprint $table) {
            $table->integer('salary')->change();
        });

        Schema::table('form_skills_data', function (Blueprint $table) {
            $table->dropColumn('ordering');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->foreignId('app_id')->nullable(false)->change()->constrained('applications')->cascadeOnDelete();
        });

        Schema::table('form_degree_data', function (Blueprint $table) {
            $table->text('additional')->nullable(false)->change();
        });

        Schema::table('form_blitz_data', function (Blueprint $table) {
            $table->string('salary')->change();
        });

        Schema::table('form_skills_data', function (Blueprint $table) {
            $table->integer('ordering')->nullable();
        });
    }
};
