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
            $table->string('citizenship')->after('living_address')->default('Uzbekistan');
            $table->string('nationality')->after('citizenship')->default('uzbek');
            $table->date('birth_date')->after('form_id');
            $table->string('phone_other')->nullable()->after('phone_work');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_personal_data', function (Blueprint $table) {
            $table->dropColumn('citizenship');
            $table->dropColumn('nationality');
            $table->dropColumn('birth_date');
            $table->dropColumn('phone_other');
        });
    }
};
