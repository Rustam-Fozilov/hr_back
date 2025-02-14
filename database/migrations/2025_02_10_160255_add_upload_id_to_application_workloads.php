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
        Schema::table('application_workloads', function (Blueprint $table) {
            $table->foreignId('upload_id')->after('status_id')->nullable()->constrained('uploads')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_workloads', function (Blueprint $table) {
            $table->dropForeign(['upload_id']);
            $table->dropColumn('upload_id');
        });
    }
};
