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
        Schema::table('form_skills_data', function (Blueprint $table) {
            $table->dropColumn('lang');
            $table->dropColumn('read_level');
            $table->dropColumn('write_level');
            $table->dropColumn('speak_level');
        });

        Schema::create('form_lang_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->cascadeOnDelete();
            $table->string('lang');
            $table->string('read_level');
            $table->string('write_level');
            $table->string('speak_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_skills_data', function (Blueprint $table) {
            $table->string('lang')->after('form_id');
            $table->string('read_level')->after('lang');
            $table->string('write_level')->after('read_level');
            $table->string('speak_level')->after('write_level');
        });
        Schema::dropIfExists('form_lang_data');
    }
};
