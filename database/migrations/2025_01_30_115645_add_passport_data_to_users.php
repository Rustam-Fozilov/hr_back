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
        Schema::table('application_users', function (Blueprint $table) {
            $table->string('passport_code', 2)->nullable()->after('pinfl');
            $table->string('passport_number', 7)->nullable()->after('passport_code');
            $table->date('passport_date')->nullable()->after('passport_number');
            $table->date('passport_end_date')->nullable()->after('passport_date');
        });

        Schema::dropIfExists('application_props');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_users', function (Blueprint $table) {
            $table->dropColumn('passport_code');
            $table->dropColumn('passport_number');
            $table->dropColumn('passport_date');
            $table->dropColumn('passport_end_date');
        });
    }
};
