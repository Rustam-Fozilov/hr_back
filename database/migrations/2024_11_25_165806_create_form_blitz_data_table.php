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
        Schema::create('form_blitz_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->cascadeOnDelete();
            $table->text('work_quality');
            $table->text('weakness');
            $table->text('wanted_skills');
            $table->text('final_career');
            $table->text('reason_for_demission');
            $table->string('service_trip_period');
            $table->string('criminal_works');
            $table->string('networking');
            $table->string('networking_fio')->nullable();
            $table->string('where_company_know');
            $table->string('start_date');
            $table->string('salary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_blitz_data');
    }
};
