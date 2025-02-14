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
        Schema::create('form_personal_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->cascadeOnDelete();
            $table->string('birth_address');
            $table->string('phone')->nullable();
            $table->string('phone_home')->nullable();
            $table->string('phone_work')->nullable();
            $table->string('email')->nullable();
            $table->string('living_address');
            $table->string('family_status');
            $table->string('dress_size');
            $table->string('smoke_status');
            $table->string('drink_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_personal_data');
    }
};
