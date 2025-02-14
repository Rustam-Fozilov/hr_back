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
        Schema::table('application_histories', function (Blueprint $table) {
            $table->text('comment')->nullable()->after('step_number');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_histories', function (Blueprint $table) {
            $table->dropColumn('comment');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->text('comment')->nullable()->after('workload_type');
        });
    }
};
