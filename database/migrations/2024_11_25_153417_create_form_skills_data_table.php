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
        Schema::create('form_skills_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->cascadeOnDelete();
            $table->string('lang');
            $table->string('read_level');
            $table->string('write_level');
            $table->string('speak_level');
            $table->string('ms_word');
            $table->string('internet');
            $table->string('ms_excel');
            $table->string('1c');
            $table->string('car_model')->nullable();
            $table->string('car_year')->nullable();
            $table->string('driver_license')->nullable();
            $table->integer('ordering')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_skills_data');
    }
};
