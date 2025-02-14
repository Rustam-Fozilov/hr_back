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
        Schema::table('form_blitz_data', function (Blueprint $table) {
            $table->renameColumn('work_quality', 'work_quality_1');
            $table->text('work_quality_2')->after('work_quality_1');
            $table->text('work_quality_3')->after('work_quality_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_blitz_data', function (Blueprint $table) {
            $table->renameColumn('work_quality_1', 'work_quality');
            $table->dropColumn('work_quality_2');
            $table->dropColumn('work_quality_3');
        });
    }
};
