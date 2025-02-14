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
        Schema::table('form_personal_data', function (Blueprint $table) {
            $table->string('birth_address')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('phone_home')->nullable()->change();
            $table->string('phone_work')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('living_address')->nullable()->change();
            $table->string('family_status')->nullable()->change();
            $table->string('dress_size')->nullable()->change();
            $table->string('smoke_status')->nullable()->change();
            $table->string('drink_status')->nullable()->change();
            $table->string('citizenship')->nullable()->change();
            $table->string('nationality')->nullable()->change();
            $table->string('birth_date')->nullable()->change();
        });

        Schema::table('form_blitz_data', function (Blueprint $table) {
            $table->string('work_quality_1')->nullable()->change();
            $table->string('work_quality_2')->nullable()->change();
            $table->string('work_quality_3')->nullable()->change();
            $table->string('weakness')->nullable()->change();
            $table->string('wanted_skills')->nullable()->change();
            $table->string('final_career')->nullable()->change();
            $table->string('reason_for_demission')->nullable()->change();
            $table->string('service_trip_period')->nullable()->change();
            $table->string('criminal_works')->nullable()->change();
            $table->string('networking')->nullable()->change();
            $table->string('networking_fio')->nullable()->change();
            $table->string('where_company_know')->nullable()->change();
            $table->string('start_date')->nullable()->change();
            $table->string('salary')->nullable()->change();
        });

        Schema::table('form_degree_data', function (Blueprint $table) {
            $table->string('entrance_year')->nullable()->change();
            $table->string('graduation_year')->nullable()->change();
            $table->string('university')->nullable()->change();
            $table->string('degree')->nullable()->change();
            $table->string('speciality')->nullable()->change();
            $table->string('additional')->nullable()->change();
        });

        Schema::table('form_importance_data', function (Blueprint $table) {
            $table->string('salary')->nullable()->change();
            $table->string('stability')->nullable()->change();
            $table->string('new_skills')->nullable()->change();
            $table->string('flexible_work_hours')->nullable()->change();
            $table->string('work_interest')->nullable()->change();
            $table->string('team_env')->nullable()->change();
            $table->string('work_in_office')->nullable()->change();
            $table->string('company_rating')->nullable()->change();
            $table->string('near_home')->nullable()->change();
        });

        Schema::table('form_lang_data', function (Blueprint $table) {
            $table->string('lang')->nullable()->change();
            $table->string('read_level')->nullable()->change();
            $table->string('write_level')->nullable()->change();
            $table->string('speak_level')->nullable()->change();
        });

        Schema::table('form_relative_data', function (Blueprint $table) {
            $table->string('relative_type')->nullable()->change();
            $table->string('fio')->nullable()->change();
            $table->string('birth_date')->nullable()->change();
            $table->string('work_place')->nullable()->change();
            $table->string('living_address')->nullable()->change();
            $table->string('ordering')->nullable()->change();
        });

        Schema::table('form_skills_data', function (Blueprint $table) {
            $table->string('ms_word')->nullable()->change();
            $table->string('internet')->nullable()->change();
            $table->string('ms_excel')->nullable()->change();
            $table->string('1c')->nullable()->change();
            $table->string('car_model')->nullable()->change();
            $table->string('car_year')->nullable()->change();
            $table->string('driver_license')->nullable()->change();
        });

        Schema::table('form_work_experience_data', function (Blueprint $table) {
            $table->string('start_date')->nullable()->change();
            $table->string('end_date')->nullable()->change();
            $table->string('company_name')->nullable()->change();
            $table->string('position')->nullable()->change();
            $table->string('company_person_count')->nullable()->change();
            $table->string('under_person_count')->nullable()->change();
            $table->string('activities')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
