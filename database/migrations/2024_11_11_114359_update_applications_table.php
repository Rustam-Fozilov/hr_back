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
            $table->date('fire_date')->nullable()->after('step_number');
            $table->integer('workload_type')->nullable()->after('fire_date')->comment('Тип обходного листа 1-office, 2-magazin');
            $table->integer('status')->default(1)->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('fire_date');
            $table->dropColumn('workload_type');
            $table->dropColumn('status');
        });
    }
};
