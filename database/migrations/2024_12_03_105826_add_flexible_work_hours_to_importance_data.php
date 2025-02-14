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
        Schema::table('form_importance_data', function (Blueprint $table) {
            $table->integer('flexible_work_hours')->after('new_skills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_importance_data', function (Blueprint $table) {
            $table->dropColumn('flexible_work_hours');
        });
    }
};
