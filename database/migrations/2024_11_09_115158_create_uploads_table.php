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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('hash_name');
            $table->string('name');
            $table->string('mime_type')->comment('fayl mime turi: img, pdf');
            $table->tinyInteger('type')->comment('fayl turi: 1-rasm, 2-video, ...');
            $table->bigInteger('size')->comment('fayl hajmi kb');
            $table->string('path', 512)->comment('serverdagi manzili');
            $table->string('url', 512)->unique()->comment('fayl url');
            $table->tinyInteger('status')->default(0)->comment("0-endi yuklandi, 1-ishlatilayotgan fayl");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
