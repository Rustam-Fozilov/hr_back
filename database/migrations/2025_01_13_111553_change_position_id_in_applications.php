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
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
        });

        Schema::table('application_users', function (Blueprint $table) {
            $table->foreignId('position_id')->nullable()->after('pinfl')->constrained('positions')->nullOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('position');
            $table->foreignId('position_id')->nullable()->after('pinfl')->constrained('positions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->foreignId('position_id')->nullable()->after('fire_date')->constrained('positions')->nullOnDelete();
        });

        Schema::table('application_users', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');

            $table->string('position')->nullable()->after('pinfl');
        });
    }
};
