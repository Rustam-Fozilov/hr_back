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
        Schema::dropIfExists('invoice_products');
        Schema::dropIfExists('products');
        Schema::dropIfExists('step_options');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
