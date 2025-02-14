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
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');

            $table->string('surname')->after('name');
            $table->string('patronymic')->after('surname')->nullable();
            $table->string('phone')->unique()->after('patronymic');
            $table->string('pinfl')->unique()->after('phone')->nullable();
            $table->boolean('is_admin')->after('pinfl')->default(false);
            $table->foreignId('role_id')->after('is_admin')->constrained()->cascadeOnDelete();
            $table->tinyInteger('status')->after('role_id')->default(1);
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
