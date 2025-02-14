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
        Schema::create('form_importance_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->cascadeOnDelete();
            $table->unsignedTinyInteger('salary');
            $table->unsignedTinyInteger('stability');
            $table->unsignedTinyInteger('new_skills');
            $table->unsignedTinyInteger('work_interest');
            $table->unsignedTinyInteger('team_env');
            $table->unsignedTinyInteger('work_in_office');
            $table->unsignedTinyInteger('company_rating');
            $table->unsignedTinyInteger('near_home');
            $table->unsignedTinyInteger('career_growth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_importance_data');
    }
};
