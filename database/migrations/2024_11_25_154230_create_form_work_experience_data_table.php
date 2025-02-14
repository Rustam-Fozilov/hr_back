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
        Schema::create('form_work_experience_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('company_name');
            $table->string('position');
            $table->unsignedInteger('company_person_count')->nullable();
            $table->unsignedInteger('under_person_count')->nullable()->comment('Rahbarlar uchun ishchilari soni');
            $table->text('activities');
            $table->text('reason_for_leaving');
            $table->integer('salary');
            $table->text('achievements');
            $table->integer('ordering');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_work_experience_data');
    }
};
