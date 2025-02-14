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
        Schema::table('users', function (Blueprint $table) {
            $table->date('hire_date')->nullable()->after('birth_date');
            $table->foreignId('avatar_id')->nullable()->after('hire_date')->constrained('uploads')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('hire_date');
            $table->dropForeign(['avatar_id']);
            $table->dropColumn('avatar_id');
        });
    }
};
