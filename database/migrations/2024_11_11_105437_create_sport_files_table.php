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
        Schema::create('sport_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_id')->constrained('sports')->onDelete('cascade');
            $table->string('original_filename', length: 200);
            $table->string('storage_filename', length: 100);
            $table->string('path', length: 4096);
            $table->string('media_type', length: 200);  // 0 to 4294967295 store up to (4.29Gb)
            $table->unsignedInteger('size');
            $table->timestamps();
        });

        Schema::table('sport_files', function (Blueprint $table) {
            $table->index('sport_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_files');
    }
};
