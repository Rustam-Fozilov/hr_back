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
        Schema::table('form_relative_data', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('living_address');
        });

        Schema::table('form_personal_data', function (Blueprint $table) {
            $table->string('dress_size')->nullable()->change();
            $table->string('smoke_status')->nullable()->change();
            $table->string('drink_status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_relative_data', function (Blueprint $table) {
            $table->dropColumn('phone');
        });

        Schema::table('form_personal_data', function (Blueprint $table) {
            $table->string('dress_size')->nullable(false)->change();
            $table->string('smoke_status')->nullable(false)->change();
            $table->string('drink_status')->nullable(false)->change();
        });
    }
};
