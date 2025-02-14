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
        Schema::table('form_work_experience_data', function (Blueprint $table) {
            $table->text('reason_for_leaving')->nullable()->change();
            $table->integer('salary')->nullable()->change();
            $table->text('achievements')->nullable()->change();
        });

        Schema::table('form_importance_data', function (Blueprint $table) {
            $table->tinyInteger('career_growth')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_work_experience_data', function (Blueprint $table) {
            $table->text('reason_for_leaving')->nullable(false)->change();
            $table->integer('salary')->nullable(false)->change();
            $table->text('achievements')->nullable(false)->change();
        });

        Schema::table('form_importance_data', function (Blueprint $table) {
            $table->tinyInteger('career_growth')->nullable(false)->change();
        });
    }
};
